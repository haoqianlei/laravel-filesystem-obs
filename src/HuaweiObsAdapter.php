<?php

namespace back\HuaweiOBS;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use League\Flysystem\Config;
use League\Flysystem\DirectoryAttributes;
use League\Flysystem\FileAttributes;
use League\Flysystem\FilesystemAdapter;
use League\Flysystem\PathPrefixer;
use League\Flysystem\StorageAttributes;
use League\Flysystem\UnableToCheckDirectoryExistence;
use League\Flysystem\UnableToCheckExistence;
use League\Flysystem\UnableToCopyFile;
use League\Flysystem\UnableToCreateDirectory;
use League\Flysystem\UnableToDeleteFile;
use League\Flysystem\UnableToGeneratePublicUrl;
use League\Flysystem\UnableToGenerateTemporaryUrl;
use League\Flysystem\UnableToListContents;
use League\Flysystem\UnableToMoveFile;
use League\Flysystem\UnableToReadFile;
use League\Flysystem\UnableToRetrieveMetadata;
use League\Flysystem\UnableToSetVisibility;
use League\Flysystem\UnableToWriteFile;
use League\MimeTypeDetection\FinfoMimeTypeDetector;
use League\MimeTypeDetection\MimeTypeDetector;
use back\HuaweiOBS\Contracts\PortableVisibilityConverter;
use back\HuaweiOBS\Contracts\VisibilityConverter;
use back\HuaweiOBS\Obs\ObsClient;
use back\HuaweiOBS\Obs\ObsException;

class HuaweiObsAdapter implements FilesystemAdapter
{
    /**
     * @var array<int, string>
     */
    protected const META_OPTIONS = [
        'CacheControl',
        'Expires',
        'SseKms',
        'MetadataDirective',
        'ACL',
        'ContentType',
        'ContentDisposition',
        'ContentLanguage',
        'ContentEncoding',
    ];

    /**
     * @var array<int, string>
     */
    private const EXTRA_METADATA_FIELDS = [
        'StorageClass',
        'ETag',
        'VersionId',
        'Metadata',
    ];

    // Huawei OBS Client ObsClient
    protected ObsClient $client;

    // bucket name
    protected string $bucket;

    protected string $hostname;

    protected bool $ssl;

    protected bool $isCname;

    protected string $epInternal;

    // 配置
    protected $options = [
        'Multipart' => 128,
    ];

    private MimeTypeDetector $mimeTypeDetector;

    private PathPrefixer $prefixer;

    private VisibilityConverter $visibility;

    private string $domain;

    /**
     * AliOssAdapter constructor.
     */
    public function __construct(
        ObsClient $client,
        string $bucket,
        string $hostname,
        bool $ssl,
        bool $isCname,
        string $epInternal,
        string $prefix = '',
        ?VisibilityConverter $visibility = null,
        ?MimeTypeDetector $mimeTypeDetector = null,
        array $options = [],
    ) {
        $this->client = $client;
        $this->bucket = $bucket;
        $this->hostname = $hostname;
        $this->ssl = $ssl;
        $this->isCname = $isCname;
        $this->epInternal = $epInternal;
        $this->prefixer = new PathPrefixer($prefix);
        $this->visibility = $visibility ?: new PortableVisibilityConverter();
        $this->mimeTypeDetector = $mimeTypeDetector ?: new FinfoMimeTypeDetector();
        $this->options = array_merge($this->options, $options);
        $this->domain = $this->isCname ? $this->hostname : $this->bucket . '.' . $this->hostname;
    }

    /**
     * 判断文件是否存在.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToCheckExistence
     */
    public function fileExists(string $path): bool
    {
        try {
            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
            ];

            $objectMetadata = $this->client->getObjectMetadata($options + $this->options);
            return ((int) $objectMetadata->HttpStatusCode) === 200;
        } catch (ObsException $exception) {
            $status = (int) $exception->getResponse()->getStatusCode();
            if (((int) $status / 100) == 2 || $status === 404) {
                return $status === 200;
            }
            throw UnableToCheckExistence::forLocation($path, $exception);
        } catch (\Throwable $exception) {
            throw UnableToCheckExistence::forLocation($path, $exception);
        }
    }

    /**
     * 判断文件夹是否存在.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToCheckDirectoryExistence
     */
    public function directoryExists(string $path): bool
    {
        try {
            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_DELIMITER => '/',
                ObsClient::OBS_MARKER => '',
                ObsClient::OBS_MAX_KEYS => 1,
                ObsClient::OBS_PREFIX => $this->prefixer->prefixDirectoryPath($path),
            ];
            $listObjectInfo = $this->client->listObjects($options + $this->options);

            return ! empty($listObjectInfo->Contents) || ! empty($listObjectInfo->CommonPrefixes);
        } catch (\Throwable $exception) {
            throw UnableToCheckDirectoryExistence::forLocation($path, $exception);
        }
    }

    /**
     * 写入文本.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToWriteFile
     */
    public function write(string $path, string $contents, Config $config): void
    {
        $this->upload($path, $contents, $config);
    }

    /**
     * 写入流.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToWriteFile
     */
    public function writeStream(string $path, $contents, Config $config): void
    {
        $this->upload($path, $contents, $config);
    }

    /**
     * 文本读取文件.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToReadFile
     */
    public function read(string $path): string
    {
        try {
            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
            ];

            $getObject = $this->client->getObject($options + $this->options);
            return $getObject->Body->getContents();
        } catch (ObsException $exception) {
            throw UnableToReadFile::fromLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $e) {
            throw UnableToReadFile::fromLocation($path, '', $e);
        }
    }

    /**
     * 流读取文件.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToReadFile
     */
    public function readStream(string $path)
    {
        try {
            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
            ];

            $getObject = $this->client->getObject($options + $this->options);
            return $getObject->Body->detach();
        } catch (ObsException $exception) {
            throw UnableToReadFile::fromLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $e) {
            throw UnableToReadFile::fromLocation($path, '', $e);
        }
    }

    /**
     * 删除文件.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToDeleteFile
     */
    public function delete(string $path): void
    {
        try {
            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
            ];

            $this->client->deleteObject($options + $this->options);
        } catch (ObsException $exception) {
            throw UnableToDeleteFile::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToDeleteFile::atLocation($path, '', $exception);
        }
    }

    /**
     * 删除目录.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToDeleteFile
     */
    public function deleteDirectory(string $path): void
    {
        try {
            $dirname = ltrim(rtrim($this->prefixer->prefixPath($path), '\\/') . '/', '\\/');

            $objects = $this->retrievePaginatedListing([
                ObsClient::OBS_MAX_KEYS => 1000,
                // ObsClient::OBS_DELIMITER => '/',
                ObsClient::OBS_MARKER => '',
                ObsClient::OBS_PREFIX => $dirname,
            ]);
            $dels = [];
            foreach ($objects as $object) {
                array_unshift($dels, [ObsClient::OBS_KEY => $object['Key'] ?? $object['Prefix']]);
            }
            array_push($dels, [ObsClient::OBS_KEY => $dirname]);

            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_OBJECTS => $dels,
            ];

            $this->client->deleteObjects($options + $this->options);
        } catch (ObsException $exception) {
            throw UnableToDeleteFile::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToDeleteFile::atLocation($path, '', $exception);
        }
    }

    /**
     * 创建目录.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToCreateDirectory
     */
    public function createDirectory(string $path, Config $config): void
    {
        try {
            $this->client->putObject([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path) . '/',
            ] + $this->options + $this->getOptionsFromConfig($config));
        } catch (ObsException $exception) {
            throw UnableToCreateDirectory::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToCreateDirectory::atLocation($path, 'Unknown', $exception);
        }
    }

    /**
     * 设置权限.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToSetVisibility
     */
    public function setVisibility(string $path, string $visibility): void
    {
        try {
            $this->client->setObjectAcl([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
                ObsClient::OBS_ACL => $this->visibility->visibilityToAcl($visibility),
            ] + $this->options);
        } catch (ObsException $exception) {
            throw UnableToSetVisibility::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToSetVisibility::atLocation($path, '', $exception);
        }
    }

    /**
     * 获取权限.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToRetrieveMetadata
     */
    public function visibility(string $path): FileAttributes
    {
        try {
            $acl = $this->client->getObjectAcl([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
            ] + $this->options);
        } catch (ObsException $exception) {
            throw UnableToRetrieveMetadata::visibility($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToRetrieveMetadata::visibility($path, '', $exception);
        }

        $visibility = $this->visibility->aclToVisibility(! empty(Arr::where($acl->Grants, fn($item) => strtolower(Arr::get($item, 'Grantee.URI', '')) === 'everyone' && strtolower(Arr::get($item, 'Permission', '')) === 'read')) ? 'READ' : 'PRIVATE');

        return new FileAttributes(path: $path, visibility: $visibility);
    }

    /**
     * 获取mimeType.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToRetrieveMetadata
     */
    public function mimeType(string $path): FileAttributes
    {
        $attributes = $this->fetchFileMetadata($path, FileAttributes::ATTRIBUTE_MIME_TYPE);

        if ($attributes->mimeType() === null) {
            throw UnableToRetrieveMetadata::mimeType($path);
        }

        return $attributes;
    }

    /**
     * 获取lastModified.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToRetrieveMetadata
     */
    public function lastModified(string $path): FileAttributes
    {
        $attributes = $this->fetchFileMetadata($path, FileAttributes::ATTRIBUTE_LAST_MODIFIED);

        if ($attributes->lastModified() === null) {
            throw UnableToRetrieveMetadata::lastModified($path);
        }

        return $attributes;
    }

    /**
     * 获取fileSize.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToRetrieveMetadata
     */
    public function fileSize(string $path): FileAttributes
    {
        $attributes = $this->fetchFileMetadata($path, FileAttributes::ATTRIBUTE_FILE_SIZE);

        if ($attributes->fileSize() === null) {
            throw UnableToRetrieveMetadata::fileSize($path);
        }

        return $attributes;
    }

    /**
     * 枚举列表.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToWriteFile
     */
    public function listContents(string $path, bool $deep): iterable
    {
        $prefix = trim($this->prefixer->prefixPath($path), '\\/');
        $prefix = empty($prefix) ? '' : $prefix . '/';

        $options = [
            ObsClient::OBS_MAX_KEYS => 1000,
            ObsClient::OBS_MARKER => '',
            ObsClient::OBS_PREFIX => $prefix,
        ];

        if ($deep === false) {
            $options[ObsClient::OBS_DELIMITER] = '/';
        }
        $listing = $this->retrievePaginatedListing($options);

        try {
            foreach ($listing as $item) {
                yield $this->mapObsObjectMetadata((array) $item);
            }
        } catch (\Throwable $exception) {
            throw UnableToListContents::atLocation($path, $deep, $exception);
        }
    }

    /**
     * 移动文件.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToCreateDirectory
     */
    public function move(string $from, string $to, Config $config): void
    {
        try {
            $this->copy($from, $to, $config);
            $this->delete($from);
        } catch (\Throwable $exception) {
            throw UnableToMoveFile::fromLocationTo($from, $to, $exception);
        }
    }

    /**
     * copy文件.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToCopyFile
     */
    public function copy(string $from, string $to, Config $config): void
    {
        try {
            $visibility = $this->visibility($from)->visibility();
        } catch (\Throwable $exception) {
            throw UnableToCopyFile::fromLocationTo($from, $to, $exception);
        }

        $options = $this->getOptions([ObsClient::OBS_ACL => $this->visibility->visibilityToAcl($visibility)] + $this->options, $config);

        try {
            $this->client->copyObject([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_COPY_SOURCE => $this->bucket . '/' . $this->prefixer->prefixPath($from),
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($to),
            ] + $options);
        } catch (\Throwable $exception) {
            throw UnableToCopyFile::fromLocationTo($from, $to, $exception);
        }
    }

    /**
     * modifyFile并行桶才能有，测试没通过.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToWriteFile
     */
    public function modifyFile(string $path, string $file, int $position, Config $config): void
    {
        try {
            $key = $this->prefixer->prefixPath($path);
            $options = $this->getOptions($this->options, $config);
            $shouldDetermineMimetype = $file !== '' && ! array_key_exists(ObsClient::OBS_CONTENT_TYPE, $options);

            if ($shouldDetermineMimetype && $mimeType = $this->mimeTypeDetector->detectMimeType($key, $file)) {
                $options[ObsClient::OBS_CONTENT_TYPE] = $mimeType;
            }

            $this->client->modifyFile([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $key,
                ObsClient::OBS_BODY => $file,
                ObsClient::OBS_POSITION => $position,
            ] + $options);
        } catch (ObsException $exception) {
            throw UnableToWriteFile::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToWriteFile::atLocation($path, 'Unknown', $exception);
        }
    }

    /**
     * appendObject.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToWriteFile
     */
    public function appendObject(string $path, string $content, int $position, Config $config): void
    {
        try {
            $this->client->appendObject([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
                ObsClient::OBS_BODY => $content,
                ObsClient::OBS_POSITION => $position,
            ] + $this->getOptions($this->options, $config));
        } catch (ObsException $exception) {
            throw UnableToWriteFile::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToWriteFile::atLocation($path, 'Unknown', $exception);
        }
    }

    /**
     * @Desc: 分段上传
     * @Author: Back
     * @Date: 2025/7/2
     * @Time: 19:13
     * @param string $obsPath
     * @param string $localPath
     * @param Config $config
     * @return void
     */
    public function putMultipart(string $obsPath, string $localPath, Config $config): void
    {

        try {
            $result = $this->client->initiateMultipartUpload([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($obsPath),
                'ContentType' => 'text/plain',
                'Metadata' => ['property' => 'property-value']
            ]);

            $uploadId = $result['UploadId'];

            $partNumber = 1;
            $parts = [];
            $handle = fopen($localPath, 'rb');

            while (!feof($handle)) {
                $partData = fread($handle, 5 * 1024 * 1024); // 例如 5MB

                $uploadPartResult = $this->client->uploadPart([
                    ObsClient::OBS_BUCKET => $this->bucket,
                    ObsClient::OBS_KEY => $this->prefixer->prefixPath($obsPath),
                    'UploadId' => $uploadId,
                    'PartNumber' => $partNumber,
                    'Body' => $partData,
                ]);

                $parts[] = [
                    'PartNumber' => $partNumber,
                    'ETag' => $uploadPartResult['ETag'],
                ];

                $partNumber++;
            }
            fclose($handle);

            $this->client->completeMultipartUpload([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($obsPath),
                'UploadId' => $uploadId,
                'Parts' => $parts,
            ]);
        } catch (ObsException $exception) {
            throw UnableToWriteFile::atLocation($obsPath, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToWriteFile::atLocation($obsPath, 'Unknown', $exception);
        }
    }

    /**
     * 获取公开地址.
     * @copyright (c) zishang520 All Rights Reserved
     * @throws UnableToGeneratePublicUrl
     */
    public function getUrl(string $path): string
    {
        try {
            return ($this->ssl ? 'https://' : 'http://') . $this->domain . '/' . ltrim($path, '\\/');
        } catch (\Throwable $exception) {
            throw UnableToGeneratePublicUrl::dueToError($path, $exception);
        }
    }

    /**
     * 获取临时地址.
     * @copyright (c) zishang520 All Rights Reserved
     */
    public function getTemporaryUrl(string $path, \DateTimeInterface $expiration, array $options = []): string
    {
        try {
            $url = $this->client->createSignedUrl([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
                ObsClient::OBS_EXPIRES => Carbon::now()->diffInSeconds(Carbon::parse($expiration)),
                ObsClient::OBS_METHOD => $options[ObsClient::OBS_METHOD] ?? ObsClient::OBS_HTTP_GET,
            ] + $options + $this->options);
            if ($this->epInternal == $this->hostname) {
                return $url->SignedUrl;
            }
            return preg_replace(sprintf('/%s/', preg_quote($this->bucket . '.' . $this->epInternal)), $this->domain, $url->SignedUrl, 1);
        } catch (\Throwable $exception) {
            throw UnableToGenerateTemporaryUrl::dueToError($path, $exception);
        }
    }

    /**
     * Get options for a OBS call. done.
     */
    protected function getOptions(array $options = [], ?Config $config = null): array
    {
        $options = array_merge($this->options, $options);

        if (! is_null($config)) {
            $options = array_merge($options, $this->getOptionsFromConfig($config));
        }

        foreach ([ObsClient::OBS_CONTENT_TYPE, ObsClient::OBS_CONTENT_LENGTH] as $key) {
            if ($value = $config->get($key)) {
                $options[$key] = $value;
            }
        }

        return $options;
    }

    /**
     * Retrieve options from a Config instance. done.
     */
    protected function getOptionsFromConfig(Config $config): array
    {
        $options = [];

        foreach (static::META_OPTIONS as $option) {
            $value = $config->get($option, '__NOT_SET__');

            if ($value !== '__NOT_SET__') {
                $options[$option] = $value;
            }
        }

        if ($visibility = $config->get(Config::OPTION_VISIBILITY)) {
            // For local reference
            // $options['visibility'] = $visibility;
            // For external reference
            $options[ObsClient::OBS_ACL] = $this->visibility->visibilityToAcl($visibility);
        }

        if ($mimetype = $config->get('mimetype')) {
            // For local reference
            // $options['mimetype'] = $mimetype;
            // For external reference
            $options[ObsClient::OBS_CONTENT_TYPE] = $mimetype;
        }

        return $options;
    }

    /**
     * @copyright (c) zishang520 All Rights Reserved
     */
    private function retrievePaginatedListing(array $options, bool $recursive = false): \Generator
    {
        while (true) {
            $options = [
                ObsClient::OBS_BUCKET => $this->bucket,
            ] + $options;

            $listObjectInfo = $this->client->listObjects($options + $this->options);
            $options[ObsClient::OBS_MARKER] = $listObjectInfo->NextMarker;

            foreach ($listObjectInfo->CommonPrefixes ?? [] as $object) {
                yield [
                    'Prefix' => $object['Prefix'],
                ];
                if ($recursive) {
                    yield from $this->retrievePaginatedListing([
                        ObsClient::OBS_MARKER => '',
                        ObsClient::OBS_PREFIX => $object['Prefix'],
                    ] + $options + $this->options, $recursive);
                }
            }

            foreach ($listObjectInfo->Contents as $object) {
                if ($object['Key'] === $options[ObsClient::OBS_PREFIX] && $object['Size'] === 0) {
                    continue;
                }
                if (substr($object['Key'], -1) === '/') {
                    yield [
                        'Prefix' => $object['Key'],
                    ];
                } else {
                    yield [
                        'Key' => $object['Key'],
                        'LastModified' => $object['LastModified'],
                        'ETag' => $object['ETag'],
                        'Type' => $object['Type'],
                        'ContentLength' => $object['Size'],
                        'StorageClass' => $object['StorageClass'],
                    ];
                }
            }

            // 没有更多结果了
            if ($listObjectInfo->IsTruncated !== true) {
                break;
            }
        }
    }

    /**
     * @copyright (c) zishang520 All Rights Reserved
     */
    private function fetchFileMetadata(string $path, string $type): FileAttributes
    {
        try {
            $objectMeta = $this->client->getObjectMetadata([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $this->prefixer->prefixPath($path),
            ] + $this->options);
        } catch (ObsException $exception) {
            throw UnableToRetrieveMetadata::create($path, $type, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToRetrieveMetadata::create($path, $type, '', $exception);
        }

        $attributes = $this->mapObsObjectMetadata($objectMeta->toArray(), $path);

        if (! $attributes instanceof FileAttributes) {
            throw UnableToRetrieveMetadata::create($path, $type, '');
        }

        return $attributes;
    }

    /**
     * @copyright (c) zishang520 All Rights Reserved
     */
    private function mapObsObjectMetadata(array $metadata, ?string $path = null): StorageAttributes
    {
        if ($path === null) {
            $path = $this->prefixer->stripPrefix($metadata['Key'] ?? $metadata['Prefix']);
        }

        $path = $path ?: '/'; // 修复根目录

        if (substr($path, -1) === '/') {
            return new DirectoryAttributes(rtrim($path, '\\/'));
        }

        $mimetype = $metadata['ContentType'] ?? null;
        $fileSize = $metadata['ContentLength'] ?? null;
        $fileSize = $fileSize === null ? null : (int) $fileSize;
        $dateTime = $metadata['LastModified'] ?? null;
        $lastModified = ! is_null($dateTime) ? Carbon::parse($dateTime)->getTimeStamp() : null;

        return new FileAttributes(
            path: $path,
            fileSize: $fileSize,
            lastModified: $lastModified,
            mimeType: $mimetype,
            extraMetadata: $this->extractExtraMetadata($metadata)
        );
    }

    /**
     * @copyright (c) zishang520 All Rights Reserved
     */
    private function extractExtraMetadata(array $metadata): array
    {
        $extracted = [];

        foreach (static::EXTRA_METADATA_FIELDS as $field) {
            if (isset($metadata[$field]) && $metadata[$field] !== '') {
                $extracted[$field] = $metadata[$field];
            }
        }

        return $extracted;
    }

    /**
     * @param string|resource $body
     * @throws UnableToWriteFile
     */
    private function upload(string $path, $body, Config $config): void
    {
        $key = $this->prefixer->prefixPath($path);
        $options = $this->getOptions($this->options, $config);

        $shouldDetermineMimetype = $body !== '' && ! array_key_exists(ObsClient::OBS_CONTENT_TYPE, $options);

        if ($shouldDetermineMimetype && $mimeType = $this->mimeTypeDetector->detectMimeType($key, $body)) {
            $options[ObsClient::OBS_CONTENT_TYPE] = $mimeType;
        }

        try {
            $this->client->putObject([
                ObsClient::OBS_BUCKET => $this->bucket,
                ObsClient::OBS_KEY => $key,
                ObsClient::OBS_BODY => $body,
            ] + $options);
        } catch (ObsException $exception) {
            throw UnableToWriteFile::atLocation($path, $exception->getExceptionMessage(), $exception);
        } catch (\Throwable $exception) {
            throw UnableToWriteFile::atLocation($path, 'Unknown', $exception);
        }
    }
}
