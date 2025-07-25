<?php

/**
 * Copyright 2019 Huawei Technologies Co.,Ltd.
 * Licensed under the Apache License, Version 2.0 (the "License"); you may not use
 * this file except in compliance with the License.  You may obtain a copy of the
 * License at.
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software distributed
 * under the License is distributed on an "AS IS" BASIS, WITHOUT WARRANTIES OR
 * CONDITIONS OF ANY KIND, either express or implied.  See the License for the
 * specific language governing permissions and limitations under the License.
 */

namespace back\HuaweiOBS\Obs\Internal\Resource;

class OBSRequestResource
{
    public const RESOURCE_ARRAY = [
        'operations' => [
            'createBucket' => [
                'httpMethod' => 'PUT',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'CreateBucketConfiguration',
                    ],
                ],
                'requestParameters' => [
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'LocationConstraint' => [
                        'type' => 'string',
                        'location' => 'xml',
                        'sentAs' => 'Location',
                    ],
                    'StorageClass' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-storage-class',
                        'transform' => 'storageClass',
                    ],
                ],
                'responseParameters' => [
                    'Location' => [
                        'type' => 'string',
                        'location' => 'header',
                    ],
                    'RequestId' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-request-id',
                    ],
                ],
            ],

            'listBuckets' => [
                'httpMethod' => 'GET',
                'responseParameters' => [
                    'Buckets' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'Buckets',
                        'items' => [
                            'name' => 'Bucket',
                            'type' => 'object',
                            'sentAs' => 'Bucket',
                            'properties' => [
                                'Name' => [
                                    'type' => 'string',
                                ],
                                'CreationDate' => [
                                    'type' => 'string',
                                ],
                                'Location' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                    'Owner' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'ID' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'RequestId' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-request-id',
                    ],
                ],
            ],

            'deleteBucket' => [
                'httpMethod' => 'DELETE',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'listObjects' => [
                'httpMethod' => 'GET',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Delimiter' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'delimiter',
                    ],
                    'Marker' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'marker',
                    ],
                    'MaxKeys' => [
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'max-keys',
                    ],
                    'Prefix' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'prefix',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'IsTruncated' => [
                            'type' => 'boolean',
                            'location' => 'xml',
                        ],
                        'Marker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'NextMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Contents' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Contents',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'Object',
                                'type' => 'object',
                                'properties' => [
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'LastModified' => [
                                        'type' => 'string',
                                    ],
                                    'ETag' => [
                                        'type' => 'string',
                                    ],
                                    'Size' => [
                                        'type' => 'integer',
                                    ],
                                    'StorageClass' => [
                                        'type' => 'string',
                                    ],
                                    'Type' => [
                                        'type' => 'string',
                                    ],
                                    'Owner' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'Name' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Prefix' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Delimiter' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'MaxKeys' => [
                            'type' => 'integer',
                            'location' => 'xml',
                        ],
                        'CommonPrefixes' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'CommonPrefix',
                                'type' => 'object',
                                'properties' => [
                                    'Prefix' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Location' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-bucket-location',
                        ],
                    ],
                ],
            ],

            'listVersions' => [
                'httpMethod' => 'GET',
                'specialParam' => 'versions',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Delimiter' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'delimiter',
                    ],
                    'KeyMarker' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'key-marker',
                    ],
                    'MaxKeys' => [
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'max-keys',
                    ],
                    'Prefix' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'prefix',
                    ],
                    'VersionIdMarker' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'version-id-marker',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'IsTruncated' => [
                            'type' => 'boolean',
                            'location' => 'xml',
                        ],
                        'KeyMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'VersionIdMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'NextKeyMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'NextVersionIdMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Versions' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Version',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'ObjectVersion',
                                'type' => 'object',
                                'sentAs' => 'Version',
                                'properties' => [
                                    'ETag' => [
                                        'type' => 'string',
                                    ],
                                    'Size' => [
                                        'type' => 'integer',
                                    ],
                                    'StorageClass' => [
                                        'type' => 'string',
                                    ],
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'VersionId' => [
                                        'type' => 'string',
                                    ],
                                    'IsLatest' => [
                                        'type' => 'boolean',
                                    ],
                                    'LastModified' => [
                                        'type' => 'string',
                                    ],
                                    'Type' => [
                                        'type' => 'string',
                                    ],
                                    'Owner' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'DeleteMarkers' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'DeleteMarker',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'DeleteMarkerEntry',
                                'type' => 'object',
                                'sentAs' => 'DeleteMarker',
                                'properties' => [
                                    'Owner' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'VersionId' => [
                                        'type' => 'string',
                                    ],
                                    'IsLatest' => [
                                        'type' => 'boolean',
                                    ],
                                    'LastModified' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'Name' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Prefix' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Delimiter' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'MaxKeys' => [
                            'type' => 'integer',
                            'location' => 'xml',
                        ],
                        'CommonPrefixes' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'CommonPrefix',
                                'type' => 'object',
                                'properties' => [
                                    'Prefix' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Location' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-bucket-location',
                        ],
                    ],
                ],
            ],

            'getBucketMetadata' => [
                'httpMethod' => 'HEAD',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Origin' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Origin',
                    ],
                    'RequestHeader' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Access-Control-Request-Headers',
                    ],
                ],
                'responseParameters' => [
                    'RequestId' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-request-id',
                    ],
                    'StorageClass' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-storage-class',
                    ],

                    'Location' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-bucket-location',
                    ],

                    'AllowOrigin' => [
                        'location' => 'header',
                        'sentAs' => 'access-control-allow-origin',
                    ],
                    'MaxAgeSeconds' => [
                        'location' => 'header',
                        'sentAs' => 'access-control-max-age',
                        'type' => 'integer',
                    ],
                    'ExposeHeader' => [
                        'location' => 'header',
                        'sentAs' => 'access-control-expose-headers',
                    ],
                    'AllowMethod' => [
                        'location' => 'header',
                        'sentAs' => 'access-control-allow-methods',
                    ],
                    'AllowHeader' => [
                        'location' => 'header',
                        'sentAs' => 'access-control-allow-headers',
                    ],
                ],
            ],

            'getBucketLocation' => [
                'httpMethod' => 'GET',
                'specialParam' => 'location',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Location' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketStorageInfo' => [
                'httpMethod' => 'GET',
                'specialParam' => 'storageinfo',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Size' => [
                            'type' => 'numeric',
                            'location' => 'xml',
                            'sentAs' => 'Size',
                        ],
                        'ObjectNumber' => [
                            'type' => 'integer',
                            'location' => 'xml',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketQuota' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'quota',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'Quota',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'StorageQuota' => [
                        'required' => true,
                        'type' => 'numeric',
                        'location' => 'xml',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketQuota' => [
                'httpMethod' => 'GET',
                'specialParam' => 'quota',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'StorageQuota' => [
                            'type' => 'integer',
                            'location' => 'xml',
                            'sentAs' => 'StorageQuota',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketStoragePolicy' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'storageClass',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'StorageClass',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'StorageClass' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'xml',
                        'transform' => 'storageClass',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketStoragePolicy' => [
                'httpMethod' => 'GET',
                'specialParam' => 'storageClass',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'StorageClass' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketAcl' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'acl',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'AccessControlPolicy',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'GrantRead' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read',
                    ],
                    'GrantWrite' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-write',
                    ],
                    'GrantReadAcp' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read-acp',
                    ],
                    'GrantWriteAcp' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-write-acp',
                    ],
                    'GrantFullControl' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-full-control',
                    ],
                    'GrantDeliveryRead' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read-delivered',
                    ],
                    'GrantDeliveryFullControl' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-full-control-delivered',
                    ],
                    'Owner' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'ID' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'Grants' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'AccessControlList',
                        'items' => [
                            'name' => 'Grant',
                            'type' => 'object',
                            'properties' => [
                                'Grantee' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'ID' => [
                                            'type' => 'string',
                                        ],
                                        'URI' => [
                                            'type' => 'string',
                                            'sentAs' => 'Canned',
                                            'transform' => 'aclUri',
                                        ],
                                    ],
                                ],
                                'Permission' => [
                                    'type' => 'string',
                                ],
                                'Delivered' => [
                                    'type' => 'boolean',
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketAcl' => [
                'httpMethod' => 'GET',
                'specialParam' => 'acl',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Owner' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'Grants' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'AccessControlList',
                            'items' => [
                                'name' => 'Grant',
                                'type' => 'object',
                                'sentAs' => 'Grant',
                                'properties' => [
                                    'Grantee' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                            'URI' => [
                                                'type' => 'string',
                                                'sentAs' => 'Canned',
                                            ],
                                        ],
                                    ],
                                    'Permission' => [
                                        'type' => 'string',
                                    ],
                                    'Delivered' => [
                                        'type' => 'boolean',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'setBucketLoggingConfiguration' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'logging',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'BucketLoggingStatus',
                    ],
                    'xmlAllowEmpty' => true,
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Agency' => [
                        'type' => 'string',
                        'location' => 'xml',
                    ],
                    'LoggingEnabled' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'TargetBucket' => [
                                'type' => 'string',
                            ],
                            'TargetPrefix' => [
                                'type' => 'string',
                            ],
                            'TargetGrants' => [
                                'type' => 'array',
                                'items' => [
                                    'name' => 'Grant',
                                    'type' => 'object',
                                    'properties' => [
                                        'Grantee' => [
                                            'type' => 'object',
                                            'properties' => [
                                                'ID' => [
                                                    'type' => 'string',
                                                ],
                                                'URI' => [
                                                    'type' => 'string',
                                                    'sentAs' => 'Canned',
                                                    'transform' => 'aclUri',
                                                ],
                                            ],
                                        ],
                                        'Permission' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketLoggingConfiguration' => [
                'httpMethod' => 'GET',
                'specialParam' => 'logging',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Agency' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'LoggingEnabled' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'TargetBucket' => [
                                    'type' => 'string',
                                ],
                                'TargetGrants' => [
                                    'type' => 'array',
                                    'sentAs' => 'TargetGrants',
                                    'items' => [
                                        'name' => 'Grant',
                                        'type' => 'object',
                                        'sentAs' => 'Grant',
                                        'properties' => [
                                            'Grantee' => [
                                                'type' => 'object',
                                                'properties' => [
                                                    'ID' => [
                                                        'type' => 'string',
                                                    ],
                                                    'URI' => [
                                                        'type' => 'string',
                                                        'sentAs' => 'Canned',
                                                    ],
                                                ],
                                            ],
                                            'Permission' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                                'TargetPrefix' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setFetchPolicy' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'obsfetchpolicy',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Policy' => [
                        'required' => true,
                        'type' => 'json',
                        'location' => 'body',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getFetchPolicy' => [
                'httpMethod' => 'GET',
                'specialParam' => 'obsfetchpolicy',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Policy' => [
                            'type' => 'json',
                            'location' => 'body',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'deleteFetchPolicy' => [
                'httpMethod' => 'DELETE',
                'specialParam' => 'obsfetchpolicy',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'RequestId' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-request-id',
                    ],
                ],
            ],

            'setBucketPolicy' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'policy',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Policy' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'body',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketPolicy' => [
                'httpMethod' => 'GET',
                'specialParam' => 'policy',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Policy' => [
                            'type' => 'string',
                            'location' => 'body',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setFetchJob' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'obsfetchjob',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Job' => [
                        'required' => true,
                        'type' => 'json',
                        'location' => 'body',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'JobInfo' => [
                            'type' => 'string',
                            'location' => 'body',
                        ],
                    ],
                ],
            ],

            'getFetchJob' => [
                'httpMethod' => 'GET',
                'specialParam' => 'obsfetchjob',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'JobID' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'x-fetch-job-id',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Job' => [
                            'type' => 'json',
                            'location' => 'body',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'deleteBucketPolicy' => [
                'httpMethod' => 'DELETE',
                'specialParam' => 'policy',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketLifecycleConfiguration' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'lifecycle',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'LifecycleConfiguration',
                    ],
                    'contentMd5' => true,
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Rules' => [
                        'required' => true,
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'Rule',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'name' => 'Rule',
                            'type' => 'object',
                            'sentAs' => 'Rule',
                            'properties' => [
                                'Transitions' => [
                                    'type' => 'array',
                                    'sentAs' => 'Transition',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'type' => 'object',
                                        'sentAs' => 'Transition',
                                        'properties' => [
                                            'StorageClass' => [
                                                'type' => 'string',
                                                'transform' => 'storageClass',
                                            ],
                                            'Date' => [
                                                'type' => 'string',
                                                'format' => 'date-time-middle',
                                            ],
                                            'Days' => [
                                                'type' => 'numeric',
                                            ],
                                        ],
                                    ],
                                ],
                                'Expiration' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'Date' => [
                                            'type' => 'string',
                                            'format' => 'date-time-middle',
                                        ],
                                        'Days' => [
                                            'type' => 'numeric',
                                        ],
                                    ],
                                ],
                                'NoncurrentVersionTransitions' => [
                                    'type' => 'array',
                                    'sentAs' => 'NoncurrentVersionTransition',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'type' => 'object',
                                        'sentAs' => 'NoncurrentVersionTransition',
                                        'properties' => [
                                            'StorageClass' => [
                                                'type' => 'string',
                                                'transform' => 'storageClass',
                                            ],
                                            'NoncurrentDays' => [
                                                'type' => 'numeric',
                                            ],
                                        ],
                                    ],
                                ],
                                'NoncurrentVersionExpiration' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'NoncurrentDays' => [
                                            'type' => 'numeric',
                                        ],
                                    ],
                                ],
                                'ID' => [
                                    'type' => 'string',
                                ],
                                'Prefix' => [
                                    'required' => true,
                                    'type' => 'string',
                                    'canEmpty' => true,
                                ],
                                'Status' => [
                                    'required' => true,
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketLifecycleConfiguration' => [
                'httpMethod' => 'GET',
                'specialParam' => 'lifecycle',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Rules' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Rule',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'Rule',
                                'type' => 'object',
                                'sentAs' => 'Rule',
                                'properties' => [
                                    'Transitions' => [
                                        'type' => 'array',
                                        'sentAs' => 'Transition',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'type' => 'object',
                                            'sentAs' => 'Transition',
                                            'properties' => [
                                                'StorageClass' => [
                                                    'type' => 'string',
                                                ],
                                                'Date' => [
                                                    'type' => 'string',
                                                    'format' => 'date-time-middle',
                                                ],
                                                'Days' => [
                                                    'type' => 'numeric',
                                                ],
                                            ],
                                        ],
                                    ],
                                    'Expiration' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'Date' => [
                                                'type' => 'string',
                                            ],
                                            'Days' => [
                                                'type' => 'integer',
                                            ],
                                        ],
                                    ],
                                    'NoncurrentVersionTransitions' => [
                                        'type' => 'array',
                                        'sentAs' => 'NoncurrentVersionTransition',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'type' => 'object',
                                            'sentAs' => 'NoncurrentVersionTransition',
                                            'properties' => [
                                                'StorageClass' => [
                                                    'type' => 'string',
                                                ],
                                                'NoncurrentDays' => [
                                                    'type' => 'numeric',
                                                ],
                                            ],
                                        ],
                                    ],
                                    'NoncurrentVersionExpiration' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'NoncurrentDays' => [
                                                'type' => 'integer',
                                            ],
                                        ],
                                    ],
                                    'ID' => [
                                        'type' => 'string',
                                    ],
                                    'Prefix' => [
                                        'type' => 'string',
                                    ],
                                    'Status' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'deleteBucketLifecycleConfiguration' => [
                'httpMethod' => 'DELETE',
                'specialParam' => 'lifecycle',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketWebsiteConfiguration' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'website',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'WebsiteConfiguration',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'ErrorDocument' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'Key' => [
                                'required' => true,
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'IndexDocument' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'Suffix' => [
                                'required' => true,
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'RedirectAllRequestsTo' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'HostName' => [
                                'required' => true,
                                'type' => 'string',
                            ],
                            'Protocol' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'RoutingRules' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'items' => [
                            'name' => 'RoutingRule',
                            'type' => 'object',
                            'properties' => [
                                'Condition' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'HttpErrorCodeReturnedEquals' => [
                                            'type' => 'numeric',
                                        ],
                                        'KeyPrefixEquals' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                                'Redirect' => [
                                    'required' => true,
                                    'type' => 'object',
                                    'properties' => [
                                        'HostName' => [
                                            'type' => 'string',
                                        ],
                                        'HttpRedirectCode' => [
                                            'type' => 'numeric',
                                        ],
                                        'Protocol' => [
                                            'type' => 'string',
                                        ],
                                        'ReplaceKeyPrefixWith' => [
                                            'type' => 'string',
                                        ],
                                        'ReplaceKeyWith' => [
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketWebsiteConfiguration' => [
                'httpMethod' => 'GET',
                'specialParam' => 'website',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'RedirectAllRequestsTo' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'HostName' => [
                                    'type' => 'string',
                                ],
                                'Protocol' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'IndexDocument' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'Suffix' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'ErrorDocument' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'Key' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'RoutingRules' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'items' => [
                                'name' => 'RoutingRule',
                                'type' => 'object',
                                'sentAs' => 'RoutingRule',
                                'properties' => [
                                    'Condition' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'HttpErrorCodeReturnedEquals' => [
                                                'type' => 'integer',
                                            ],
                                            'KeyPrefixEquals' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                    'Redirect' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'HostName' => [
                                                'type' => 'string',
                                            ],
                                            'HttpRedirectCode' => [
                                                'type' => 'integer',
                                            ],
                                            'Protocol' => [
                                                'type' => 'string',
                                            ],
                                            'ReplaceKeyPrefixWith' => [
                                                'type' => 'string',
                                            ],
                                            'ReplaceKeyWith' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'deleteBucketWebsiteConfiguration' => [
                'httpMethod' => 'DELETE',
                'specialParam' => 'website',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketVersioningConfiguration' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'versioning',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'VersioningConfiguration',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Status' => [
                        'type' => 'string',
                        'location' => 'xml',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketVersioningConfiguration' => [
                'httpMethod' => 'GET',
                'specialParam' => 'versioning',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Status' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                    ],
                ],
            ],

            'setBucketCors' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'cors',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'CORSConfiguration',
                    ],
                    'contentMd5' => true,
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'CorsRules' => [
                        'required' => true,
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'CORSRule',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'type' => 'object',
                            'sentAs' => 'CORSRule',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                ],
                                'AllowedMethod' => [
                                    'required' => true,
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'type' => 'string',
                                        'sentAs' => 'AllowedMethod',
                                    ],
                                ],
                                'AllowedOrigin' => [
                                    'required' => true,
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'sentAs' => 'AllowedOrigin',
                                        'type' => 'string',
                                    ],
                                ],
                                'AllowedHeader' => [
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'name' => 'AllowedHeader',
                                        'type' => 'string',
                                    ],
                                ],
                                'MaxAgeSeconds' => [
                                    'type' => 'numeric',
                                ],
                                'ExposeHeader' => [
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'name' => 'ExposeHeader',
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketCors' => [
                'httpMethod' => 'GET',
                'specialParam' => 'cors',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'CorsRules' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'CORSRule',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'type' => 'object',
                                'properties' => [
                                    'ID' => [
                                        'type' => 'string',
                                    ],
                                    'AllowedMethod' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'type' => 'string',
                                            'sentAs' => 'AllowedMethod',
                                        ],
                                    ],
                                    'AllowedOrigin' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'sentAs' => 'AllowedOrigin',
                                            'type' => 'string',
                                        ],
                                    ],
                                    'AllowedHeader' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'name' => 'AllowedHeader',
                                            'type' => 'string',
                                        ],
                                    ],
                                    'MaxAgeSeconds' => [
                                        'type' => 'integer',
                                    ],
                                    'ExposeHeader' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'name' => 'ExposeHeader',
                                            'type' => 'string',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'deleteBucketCors' => [
                'httpMethod' => 'DELETE',
                'specialParam' => 'cors',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'optionsBucket' => [
                'httpMethod' => 'OPTIONS',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Origin' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'header',
                    ],
                    'AccessControlRequestMethods' => [
                        'required' => true,
                        'type' => 'array',
                        'location' => 'header',
                        'items' => [
                            'sentAs' => 'Access-Control-Request-Method',
                            'type' => 'string',
                        ],
                    ],
                    'AccessControlRequestHeaders' => [
                        'type' => 'array',
                        'location' => 'header',
                        'items' => [
                            'sentAs' => 'Access-Control-Request-Headers',
                            'type' => 'string',
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'AllowOrigin' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-origin',
                        ],
                        'AllowHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-headers',
                        ],
                        'AllowMethod' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-methods',
                        ],
                        'ExposeHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-expose-headers',
                        ],
                        'MaxAgeSeconds' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-max-age',
                        ],
                    ],
                ],
            ],

            'setBucketTagging' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'tagging',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'Tagging',
                    ],
                    'contentMd5' => true,
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Tags' => [
                        'required' => true,
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'TagSet',
                        'items' => [
                            'required' => true,
                            'type' => 'object',
                            'name' => 'Tag',
                            'properties' => [
                                'Key' => [
                                    'required' => true,
                                    'type' => 'string',
                                ],
                                'Value' => [
                                    'required' => true,
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketTagging' => [
                'httpMethod' => 'GET',
                'specialParam' => 'tagging',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Tags' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'TagSet',
                            'items' => [
                                'type' => 'object',
                                'name' => 'Tag',
                                'properties' => [
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'Value' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'deleteBucketTagging' => [
                'httpMethod' => 'DELETE',
                'specialParam' => 'tagging',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setBucketNotification' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'notification',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'NotificationConfiguration',
                    ],
                    'xmlAllowEmpty' => true,
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'TopicConfigurations' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'TopicConfiguration',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'sentAs' => 'TopicConfiguration',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                    'sentAs' => 'Id',
                                ],
                                'Filter' => [
                                    'type' => 'array',
                                    'wrapper' => 'Filter',
                                    'sentAs' => 'Object',
                                    'items' => [
                                        'type' => 'object',
                                        'sentAs' => 'FilterRule',
                                        'properties' => [
                                            'Name' => [
                                                'type' => 'string',
                                            ],

                                            'Value' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                                'Topic' => [
                                    'type' => 'string',
                                ],
                                'Event' => [
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'type' => 'string',
                                        'sentAs' => 'Event',
                                        'transform' => 'event',
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'FunctionStageConfigurations' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'FunctionStageConfiguration',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'sentAs' => 'FunctionStageConfiguration',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                    'sentAs' => 'Id',
                                ],
                                'FunctionStage' => [
                                    'type' => 'string',
                                ],
                                'Event' => [
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'type' => 'string',
                                        'sentAs' => 'Event',
                                    ],
                                ],
                                'Filter' => [
                                    'type' => 'array',
                                    'wrapper' => 'Filter',
                                    'sentAs' => 'Object',
                                    'items' => [
                                        'type' => 'object',
                                        'sentAs' => 'FilterRule',
                                        'properties' => [
                                            'Name' => [
                                                'type' => 'string',
                                            ],

                                            'Value' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                    'FunctionGraphConfigurations' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'FunctionGraphConfiguration',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'sentAs' => 'FunctionGraphConfiguration',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                    'sentAs' => 'Id',
                                ],
                                'FunctionGraph' => [
                                    'type' => 'string',
                                ],
                                'Event' => [
                                    'type' => 'array',
                                    'data' => [
                                        'xmlFlattened' => true,
                                    ],
                                    'items' => [
                                        'type' => 'string',
                                        'sentAs' => 'Event',
                                    ],
                                ],
                                'Filter' => [
                                    'type' => 'array',
                                    'wrapper' => 'Filter',
                                    'sentAs' => 'Object',
                                    'items' => [
                                        'type' => 'object',
                                        'sentAs' => 'FilterRule',
                                        'properties' => [
                                            'Name' => [
                                                'type' => 'string',
                                            ],

                                            'Value' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'getBucketNotification' => [
                'httpMethod' => 'GET',
                'specialParam' => 'notification',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'TopicConfigurations' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'TopicConfiguration',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'type' => 'object',
                                'location' => 'xml',
                                'sentAs' => 'TopicConfiguration',
                                'properties' => [
                                    'ID' => [
                                        'type' => 'string',
                                        'sentAs' => 'Id',
                                    ],
                                    'Topic' => [
                                        'type' => 'string',
                                    ],
                                    'Event' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'type' => 'string',
                                            'sentAs' => 'Event',
                                        ],
                                    ],
                                    'Filter' => [
                                        'type' => 'array',
                                        'wrapper' => 'Filter',
                                        'sentAs' => 'Object',
                                        'items' => [
                                            'type' => 'object',
                                            'sentAs' => 'FilterRule',
                                            'properties' => [
                                                'Name' => [
                                                    'type' => 'string',
                                                ],

                                                'Value' => [
                                                    'type' => 'string',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'FunctionStageConfigurations' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'FunctionStageConfiguration',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'type' => 'object',
                                'location' => 'xml',
                                'sentAs' => 'FunctionStageConfiguration',
                                'properties' => [
                                    'ID' => [
                                        'type' => 'string',
                                        'sentAs' => 'Id',
                                    ],
                                    'FunctionStage' => [
                                        'type' => 'string',
                                    ],
                                    'Event' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'type' => 'string',
                                            'sentAs' => 'Event',
                                        ],
                                    ],
                                    'Filter' => [
                                        'type' => 'array',
                                        'wrapper' => 'Filter',
                                        'sentAs' => 'Object',
                                        'items' => [
                                            'type' => 'object',
                                            'sentAs' => 'FilterRule',
                                            'properties' => [
                                                'Name' => [
                                                    'type' => 'string',
                                                ],

                                                'Value' => [
                                                    'type' => 'string',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'FunctionGraphConfigurations' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'FunctionGraphConfiguration',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'type' => 'object',
                                'location' => 'xml',
                                'sentAs' => 'FunctionGraphConfiguration',
                                'properties' => [
                                    'ID' => [
                                        'type' => 'string',
                                        'sentAs' => 'Id',
                                    ],
                                    'FunctionGraph' => [
                                        'type' => 'string',
                                    ],
                                    'Event' => [
                                        'type' => 'array',
                                        'data' => [
                                            'xmlFlattened' => true,
                                        ],
                                        'items' => [
                                            'type' => 'string',
                                            'sentAs' => 'Event',
                                        ],
                                    ],
                                    'Filter' => [
                                        'type' => 'array',
                                        'wrapper' => 'Filter',
                                        'sentAs' => 'Object',
                                        'items' => [
                                            'type' => 'object',
                                            'sentAs' => 'FilterRule',
                                            'properties' => [
                                                'Name' => [
                                                    'type' => 'string',
                                                ],

                                                'Value' => [
                                                    'type' => 'string',
                                                ],
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
            ],

            'optionsObject' => [
                'httpMethod' => 'OPTIONS',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'Origin' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'header',
                    ],
                    'AccessControlRequestMethods' => [
                        'required' => true,
                        'type' => 'array',
                        'location' => 'header',
                        'items' => [
                            'sentAs' => 'Access-Control-Request-Method',
                            'type' => 'string',
                        ],
                    ],
                    'AccessControlRequestHeaders' => [
                        'type' => 'array',
                        'location' => 'header',
                        'items' => [
                            'sentAs' => 'Access-Control-Request-Headers',
                            'type' => 'string',
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'AllowOrigin' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-origin',
                        ],
                        'AllowHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-headers',
                        ],
                        'AllowMethod' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-methods',
                        ],
                        'ExposeHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-expose-headers',
                        ],
                        'MaxAgeSeconds' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-max-age',
                        ],
                    ],
                ],
            ],

            'deleteObject' => [
                'httpMethod' => 'DELETE',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'VersionId' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'versionId',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'DeleteMarker' => [
                            'type' => 'boolean',
                            'location' => 'header',
                            'sentAs' => 'x-obs-delete-marker',
                        ],
                        'VersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],
            'deleteObjects' => [
                'httpMethod' => 'POST',
                'specialParam' => 'delete',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'Delete',
                    ],
                    'contentMd5' => true,
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Quiet' => [
                        'type' => 'boolean',
                        'location' => 'xml',
                    ],
                    'Objects' => [
                        'required' => true,
                        'type' => 'array',
                        'location' => 'xml',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'type' => 'object',
                            'sentAs' => 'Object',
                            'properties' => [
                                'Key' => [
                                    'required' => true,
                                    'type' => 'string',
                                ],
                                'VersionId' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Deleteds' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Deleted',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'DeletedObject',
                                'type' => 'object',
                                'properties' => [
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'VersionId' => [
                                        'type' => 'string',
                                    ],
                                    'DeleteMarker' => [
                                        'type' => 'boolean',
                                    ],
                                    'DeleteMarkerVersionId' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'Errors' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Error',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'Error',
                                'type' => 'object',
                                'sentAs' => 'Error',
                                'properties' => [
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'VersionId' => [
                                        'type' => 'string',
                                    ],
                                    'Code' => [
                                        'type' => 'string',
                                    ],
                                    'Message' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'setObjectAcl' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'acl',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'AccessControlPolicy',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'VersionId' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'versionId',
                    ],
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'GrantRead' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read',
                    ],
                    'GrantWrite' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-write',
                    ],
                    'GrantReadAcp' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read-acp',
                    ],
                    'GrantWriteAcp' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-write-acp',
                    ],
                    'GrantFullControl' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-full-control',
                    ],
                    'Owner' => [
                        'type' => 'object',
                        'location' => 'xml',
                        'properties' => [
                            'ID' => [
                                'type' => 'string',
                            ],
                        ],
                    ],
                    'Delivered' => [
                        'type' => 'boolean',
                    ],
                    'Grants' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'sentAs' => 'AccessControlList',
                        'items' => [
                            'name' => 'Grant',
                            'type' => 'object',
                            'properties' => [
                                'Grantee' => [
                                    'type' => 'object',
                                    'properties' => [
                                        'ID' => [
                                            'type' => 'string',
                                        ],
                                        'URI' => [
                                            'type' => 'string',
                                            'sentAs' => 'Canned',
                                            'transform' => 'aclUri',
                                        ],
                                    ],
                                ],
                                'Permission' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                ],
                'responseParameters' => [
                    'RequestId' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-request-id',
                    ],
                ],
            ],

            'getObjectAcl' => [
                'httpMethod' => 'GET',
                'specialParam' => 'acl',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'VersionId' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'versionId',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Owner' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'Delivered' => [
                            'type' => 'boolean',
                            'location' => 'xml',
                        ],
                        'Grants' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'AccessControlList',
                            'items' => [
                                'name' => 'Grant',
                                'type' => 'object',
                                'sentAs' => 'Grant',
                                'properties' => [
                                    'Grantee' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                            'URI' => [
                                                'type' => 'string',
                                                'sentAs' => 'Canned',
                                            ],
                                        ],
                                    ],
                                    'Permission' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'VersionId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                    ],
                ],
            ],

            'restoreObject' => [
                'httpMethod' => 'POST',
                'specialParam' => 'restore',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'RestoreRequest',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'VersionId' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'versionId',
                    ],
                    'Days' => [
                        'required' => true,
                        'type' => 'numeric',
                        'location' => 'xml',
                        'sentAs' => 'Days',
                    ],
                    'Tier' => [
                        'wrapper' => 'RestoreJob',
                        'type' => 'string',
                        'sentAs' => 'Tier',
                        'location' => 'xml',
                    ],
                ],
                'responseParameters' => [
                    'RequestId' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-request-id',
                    ],
                ],
            ],

            'putObject' => [
                'httpMethod' => 'PUT',
                'requestParameters' => [
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'StorageClass' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-storage-class',
                        'transform' => 'storageClass',
                    ],
                    'Body' => [
                        'type' => 'stream',
                        'location' => 'body',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'ContentMD5' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Content-MD5',
                    ],
                    'ContentType' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Content-Type',
                    ],
                    'ContentLength' => [
                        'type' => 'numeric',
                        'location' => 'header',
                        'sentAs' => 'Content-Length',
                    ],
                    'Metadata' => [
                        'type' => 'object',
                        'location' => 'header',
                        'sentAs' => 'x-obs-meta-',
                    ],
                    'SourceFile' => [
                        'type' => 'file',
                        'location' => 'body',
                    ],
                    'WebsiteRedirectLocation' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-website-redirect-location',
                    ],
                    'SseKms' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption',
                    ],
                    'SseKmsKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                    'SseCKeyMd5' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                    ],
                    'SuccessRedirect' => [
                        'location' => 'header',
                        'type' => 'string',
                        'sentAs' => 'success-action-redirect',
                    ],
                    'Expires' => [
                        'location' => 'header',
                        'type' => 'string',
                        'sentAs' => 'x-obs-expires',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'VersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'StorageClass' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-storage-class',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                    ],
                ],
            ],

            'getObject' => [
                'httpMethod' => 'GET',
                'stream' => true,
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'IfMatch' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'If-Match',
                    ],
                    'IfModifiedSince' => [
                        'type' => 'string',
                        'format' => 'date-time-http',
                        'location' => 'header',
                        'sentAs' => 'If-Modified-Since',
                    ],
                    'IfNoneMatch' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'If-None-Match',
                    ],
                    'IfUnmodifiedSince' => [
                        'type' => 'string',
                        'format' => 'date-time-http',
                        'location' => 'header',
                        'sentAs' => 'If-Unmodified-Since',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'Range' => [
                        'type' => 'string',
                        'location' => 'header',
                    ],
                    'ImageProcess' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'x-image-process',
                    ],
                    'ResponseCacheControl' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'response-cache-control',
                    ],
                    'ResponseContentDisposition' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'response-content-disposition',
                    ],
                    'ResponseContentEncoding' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'response-content-encoding',
                    ],
                    'ResponseContentLanguage' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'response-content-language',
                    ],
                    'ResponseContentType' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'response-content-type',
                    ],
                    'ResponseExpires' => [
                        'type' => 'string',
                        'format' => 'date-time-http',
                        'location' => 'query',
                        'sentAs' => 'response-expires',
                    ],
                    'VersionId' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'versionId',
                    ],
                    'SaveAsFile' => [
                        'type' => 'file',
                        'location' => 'response',
                    ],
                    'FilePath' => [
                        'type' => 'file',
                        'location' => 'response',
                    ],

                    'Origin' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Origin',
                    ],
                    'RequestHeader' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Access-Control-Request-Headers',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Body' => [
                            'type' => 'stream',
                            'location' => 'body',
                        ],
                        'DeleteMarker' => [
                            'type' => 'boolean',
                            'location' => 'header',
                            'sentAs' => 'x-obs-delete-marker',
                        ],
                        'Expiration' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-expiration',
                        ],
                        'LastModified' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'last-modified',
                        ],
                        'ContentLength' => [
                            'type' => 'integer',
                            'location' => 'header',
                            'sentAs' => 'content-length',
                        ],
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'etag',
                        ],
                        'VersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                        'CacheControl' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'cache-control',
                        ],
                        'ContentDisposition' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'content-disposition',
                        ],
                        'ContentEncoding' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'content-encoding',
                        ],
                        'ContentLanguage' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'content-language',
                        ],
                        'ContentType' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'content-type',
                        ],
                        'Expires' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'WebsiteRedirectLocation' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-website-redirect-location',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'StorageClass' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-storage-class',
                        ],
                        'Restore' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-restore',
                        ],
                        'AllowOrigin' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-origin',
                        ],
                        'MaxAgeSeconds' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-max-age',
                        ],
                        'ExposeHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-expose-headers',
                        ],
                        'AllowMethod' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-methods',
                        ],
                        'AllowHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-headers',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                        'Metadata' => [
                            'location' => 'header',
                            'type' => 'object',
                            'sentAs' => 'x-obs-meta-',
                        ],
                        'ObjectType' => [
                            'location' => 'header',
                            'type' => 'string',
                            'sentAs' => 'x-obs-object-type',
                        ],
                        'AppendPosition' => [
                            'location' => 'header',
                            'type' => 'string',
                            'sentAs' => 'x-obs-next-append-position',
                        ],
                    ],
                ],
            ],

            'copyObject' => [
                'httpMethod' => 'PUT',
                'requestParameters' => [
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'StorageClass' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-storage-class',
                        'transform' => 'storageClass',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'CopySource' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source',
                    ],
                    'CopySourceIfMatch' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-if-match',
                    ],
                    'CopySourceIfModifiedSince' => [
                        'type' => 'string',
                        'format' => 'date-time-http',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-if-modified-since',
                    ],
                    'CopySourceIfNoneMatch' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-if-none-match',
                    ],
                    'CopySourceIfUnmodifiedSince' => [
                        'type' => 'string',
                        'format' => 'date-time-http',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-if-unmodified-since',
                    ],
                    'MetadataDirective' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-metadata-directive',
                    ],
                    'ContentType' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'content-type',
                    ],
                    'ContentEncoding' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'content-encoding',
                    ],
                    'ContentLanguage' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'content-language',
                    ],
                    'ContentDisposition' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'content-disposition',
                    ],
                    'CacheControl' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'cache-control',
                    ],
                    'Expires' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'expires',
                    ],
                    'Metadata' => [
                        'type' => 'object',
                        'location' => 'header',
                        'sentAs' => 'x-obs-meta-',
                    ],
                    'WebsiteRedirectLocation' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-website-redirect-location',
                    ],
                    'SseKms' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption',
                    ],
                    'SseKmsKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                    'SseCKeyMd5' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                    ],
                    'CopySourceSseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-server-side-encryption-customer-algorithm',
                    ],
                    'CopySourceSseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'LastModified' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'VersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                        'CopySourceVersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-copy-source-version-id',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                    ],
                ],
            ],

            'appendObject' => [
                'httpMethod' => 'POST',
                'specialParam' => 'append',
                'requestParameters' => [
                    'Body' => [
                        'type' => 'stream',
                        'location' => 'body',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'Position' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'position',
                    ],
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'GrantRead' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read',
                    ],
                    'GrantReadAcp' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-read-acp',
                    ],
                    'GrantWriteAcp' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-write-acp',
                    ],
                    'GrantFullControl' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-grant-full-control',
                    ],
                    'StorageClass' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-storage-class',
                    ],
                    'Metadata' => [
                        'type' => 'object',
                        'location' => 'header',
                        'sentAs' => 'x-obs-meta-',
                    ],
                    'PersistentHeaders' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-persistent-headers',
                    ],
                    'WebsiteRedirectLocation' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-website-redirect-location',
                    ],
                    'Expires' => [
                        'location' => 'header',
                        'type' => 'string',
                        'sentAs' => 'x-obs-expires',
                    ],
                    'SseKms' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption',
                    ],
                    'SseKmsKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                    'SseCKeyMd5' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Date' => [
                            'type' => 'string',
                            'location' => 'header',
                            'format' => 'date-time-middle',
                        ],
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'ContentLength' => [
                            'type' => 'integer',
                            'location' => 'header',
                            'sentAs' => 'content-length',
                        ],
                    ],
                ],
            ],

            'modifyFile' => [
                'httpMethod' => 'PUT',
                'specialParam' => 'modify',
                'requestParameters' => [
                    'Body' => [
                        'type' => 'stream',
                        'location' => 'body',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'Position' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'position',
                    ],
                    'ContentType' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'content-type',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Date' => [
                            'type' => 'string',
                            'location' => 'header',
                            'format' => 'date-time-middle',
                        ],
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'Server' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'ContentLength' => [
                            'type' => 'integer',
                            'location' => 'header',
                            'sentAs' => 'content-length',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'Id' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-id-2',
                        ],
                    ],
                ],
            ],

            'getObjectMetadata' => [
                'httpMethod' => 'HEAD',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'VersionId' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'versionId',
                    ],
                    'Origin' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Origin',
                    ],
                    'RequestHeader' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Access-Control-Request-Headers',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Expiration' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-expiration',
                        ],
                        'LastModified' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'last-modified',
                        ],
                        'ContentLength' => [
                            'type' => 'integer',
                            'location' => 'header',
                            'sentAs' => 'content-length',
                        ],
                        'ContentType' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'content-type',
                        ],
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'VersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                        'WebsiteRedirectLocation' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-website-redirect-location',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'StorageClass' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-storage-class',
                        ],
                        'AllowOrigin' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-origin',
                        ],
                        'MaxAgeSeconds' => [
                            'type' => 'integer',
                            'location' => 'header',
                            'sentAs' => 'access-control-max-age',
                        ],
                        'ExposeHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-expose-headers',
                        ],
                        'AllowMethod' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-methods',
                        ],
                        'AllowHeader' => [
                            'location' => 'header',
                            'sentAs' => 'access-control-allow-headers',
                        ],
                        'Restore' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-restore',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                        'Metadata' => [
                            'location' => 'header',
                            'type' => 'object',
                            'sentAs' => 'x-obs-meta-',
                        ],
                        'ObjectType' => [
                            'location' => 'header',
                            'type' => 'string',
                            'sentAs' => 'x-obs-object-type',
                        ],
                        'AppendPosition' => [
                            'location' => 'header',
                            'type' => 'string',
                            'sentAs' => 'x-obs-next-append-position',
                        ],
                    ],
                ],
            ],

            'initiateMultipartUpload' => [
                'httpMethod' => 'POST',
                'specialParam' => 'uploads',
                'requestParameters' => [
                    'ACL' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-acl',
                        'transform' => 'aclHeader',
                    ],
                    'StorageClass' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-storage-class',
                        'transform' => 'storageClass',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'ContentType' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Content-Type',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'Metadata' => [
                        'type' => 'object',
                        'location' => 'header',
                        'sentAs' => 'x-obs-meta-',
                    ],
                    'WebsiteRedirectLocation' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-website-redirect-location',
                    ],
                    'SseKms' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption',
                    ],
                    'SseKmsKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                    'SseCKeyMd5' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                    ],
                    'Expires' => [
                        'location' => 'header',
                        'type' => 'string',
                        'sentAs' => 'x-obs-expires',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Bucket' => [
                            'type' => 'string',
                            'location' => 'xml',
                            'sentAs' => 'Bucket',
                        ],
                        'Key' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'UploadId' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                    ],
                ],
            ],

            'listMultipartUploads' => [
                'httpMethod' => 'GET',
                'specialParam' => 'uploads',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Delimiter' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'delimiter',
                    ],
                    'KeyMarker' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'key-marker',
                    ],
                    'MaxUploads' => [
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'max-uploads',
                    ],
                    'Prefix' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'prefix',
                    ],
                    'UploadIdMarker' => [
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'upload-id-marker',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Bucket' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'KeyMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'UploadIdMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'NextKeyMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Prefix' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Delimiter' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'NextUploadIdMarker' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'MaxUploads' => [
                            'type' => 'numeric',
                            'location' => 'xml',
                        ],
                        'IsTruncated' => [
                            'type' => 'boolean',
                            'location' => 'xml',
                        ],
                        'Uploads' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Upload',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'MultipartUpload',
                                'type' => 'object',
                                'sentAs' => 'Upload',
                                'properties' => [
                                    'UploadId' => [
                                        'type' => 'string',
                                    ],
                                    'Key' => [
                                        'type' => 'string',
                                    ],
                                    'Initiated' => [
                                        'type' => 'string',
                                    ],
                                    'StorageClass' => [
                                        'type' => 'string',
                                    ],
                                    'Owner' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                    'Initiator' => [
                                        'type' => 'object',
                                        'properties' => [
                                            'ID' => [
                                                'type' => 'string',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'CommonPrefixes' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'CommonPrefix',
                                'type' => 'object',
                                'properties' => [
                                    'Prefix' => [
                                        'type' => 'string',
                                    ],
                                ],
                            ],
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'abortMultipartUpload' => [
                'httpMethod' => 'DELETE',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'UploadId' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'uploadId',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'uploadPart' => [
                'httpMethod' => 'PUT',
                'requestParameters' => [
                    'Body' => [
                        'type' => 'stream',
                        'location' => 'body',
                    ],
                    'SourceFile' => [
                        'type' => 'file',
                        'location' => 'body',
                    ],
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'PartNumber' => [
                        'required' => true,
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'partNumber',
                    ],
                    'UploadId' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'uploadId',
                    ],
                    'Offset' => [
                        'type' => 'numeric',
                        'location' => 'response',
                    ],
                    'PartSize' => [
                        'type' => 'numeric',
                        'location' => 'response',
                    ],
                    'ContentMD5' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Content-MD5',
                    ],
                    'ContentType' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'Content-Type',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'header',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                    ],
                ],
            ],

            'completeMultipartUpload' => [
                'httpMethod' => 'POST',
                'data' => [
                    'xmlRoot' => [
                        'name' => 'CompleteMultipartUpload',
                    ],
                ],
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'Parts' => [
                        'type' => 'array',
                        'location' => 'xml',
                        'data' => [
                            'xmlFlattened' => true,
                        ],
                        'items' => [
                            'name' => 'CompletedPart',
                            'type' => 'object',
                            'sentAs' => 'Part',
                            'properties' => [
                                'PartNumber' => [
                                    'type' => 'numeric',
                                ],
                                'ETag' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                    ],
                    'UploadId' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'uploadId',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Location' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Bucket' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Key' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Location' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'VersionId' => [
                            'type' => 'string',
                            'location' => 'header',
                            'sentAs' => 'x-obs-version-id',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                    ],
                ],
            ],

            'listParts' => [
                'httpMethod' => 'GET',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'MaxParts' => [
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'max-parts',
                    ],
                    'PartNumberMarker' => [
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'part-number-marker',
                    ],
                    'UploadId' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'uploadId',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'Bucket' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'Key' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'UploadId' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'PartNumberMarker' => [
                            'type' => 'numeric',
                            'location' => 'xml',
                        ],
                        'NextPartNumberMarker' => [
                            'type' => 'numeric',
                            'location' => 'xml',
                        ],
                        'MaxParts' => [
                            'type' => 'numeric',
                            'location' => 'xml',
                        ],
                        'IsTruncated' => [
                            'type' => 'boolean',
                            'location' => 'xml',
                        ],
                        'Parts' => [
                            'type' => 'array',
                            'location' => 'xml',
                            'sentAs' => 'Part',
                            'data' => [
                                'xmlFlattened' => true,
                            ],
                            'items' => [
                                'name' => 'Part',
                                'type' => 'object',
                                'sentAs' => 'Part',
                                'properties' => [
                                    'PartNumber' => [
                                        'type' => 'integer',
                                    ],
                                    'LastModified' => [
                                        'type' => 'string',
                                    ],
                                    'ETag' => [
                                        'type' => 'string',
                                    ],
                                    'Size' => [
                                        'type' => 'integer',
                                    ],
                                ],
                            ],
                        ],
                        'Initiator' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'Owner' => [
                            'type' => 'object',
                            'location' => 'xml',
                            'properties' => [
                                'ID' => [
                                    'type' => 'string',
                                ],
                            ],
                        ],
                        'StorageClass' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                    ],
                ],
            ],

            'copyPart' => [
                'httpMethod' => 'PUT',
                'requestParameters' => [
                    'Bucket' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'dns',
                    ],
                    'CopySource' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source',
                    ],
                    'CopySourceRange' => [
                        'type' => 'string',
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-range',
                    ],
                    'Key' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'uri',
                    ],
                    'PartNumber' => [
                        'required' => true,
                        'type' => 'numeric',
                        'location' => 'query',
                        'sentAs' => 'partNumber',
                    ],
                    'UploadId' => [
                        'required' => true,
                        'type' => 'string',
                        'location' => 'query',
                        'sentAs' => 'uploadId',
                    ],
                    'SseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                    ],
                    'SseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                    'CopySourceSseC' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-server-side-encryption-customer-algorithm',
                    ],
                    'CopySourceSseCKey' => [
                        'location' => 'header',
                        'sentAs' => 'x-obs-copy-source-server-side-encryption-customer-key',
                        'type' => 'password',
                    ],
                ],
                'responseParameters' => [
                    'type' => 'object',
                    'properties' => [
                        'ETag' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'LastModified' => [
                            'type' => 'string',
                            'location' => 'xml',
                        ],
                        'RequestId' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-request-id',
                        ],
                        'SseKms' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption',
                        ],
                        'SseKmsKey' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-kms-key-id',
                        ],
                        'SseC' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-algorithm',
                        ],
                        'SseCKeyMd5' => [
                            'location' => 'header',
                            'sentAs' => 'x-obs-server-side-encryption-customer-key-MD5',
                        ],
                    ],
                ],
            ],
        ],

        'aliases' => [
            'headBucket' => 'getBucketMetadata',

            'getBucketLogging' => 'getBucketLoggingConfiguration',
            'setBucketLogging' => 'setBucketLoggingConfiguration',
            'getBucketVersioning' => 'getBucketVersioningConfiguration',
            'setBucketVersioning' => 'setBucketVersioningConfiguration',
            'setBucketWebsite' => 'setBucketWebsiteConfiguration',
            'getBucketWebsite' => 'getBucketWebsiteConfiguration',
            'deleteBucketWebsite' => 'deleteBucketWebsiteConfiguration',
            'setBucketLifecycle' => 'setBucketLifecycleConfiguration',
            'getBucketLifecycle' => 'getBucketLifecycleConfiguration',
            'deleteBucketLifecycle' => 'deleteBucketLifecycleConfiguration',
        ],
    ];
}
