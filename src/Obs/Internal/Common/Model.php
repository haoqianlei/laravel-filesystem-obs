<?php

namespace back\HuaweiOBS\Obs\Internal\Common;

class Model implements \Stringable, \ArrayAccess, \IteratorAggregate, \Countable, ToArrayInterface
{
    /** @var array Data associated with the object. */
    protected array $data;

    /**
     * @param array $data Associative array of data to set
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * Provides debug information about the model object.
     */
    public function __toString(): string
    {
        $output = 'Debug output of ';
        $output .= 'model';
        $output = str_repeat('=', strlen($output)) . "\n" . $output . "\n" . str_repeat('=', strlen($output)) . "\n\n";
        $output .= "Model data\n-----------\n\n";
        $output .= 'This data can be retrieved from the model object using the get() method of the model '
            . "(e.g. \$model->get(\$key)) or accessing the model like an associative array (e.g. \$model['key']).\n\n";
        $lines = array_slice(explode("\n", trim(print_r($this->toArray(), true))), 2, -1);
        $output .= implode("\n", $lines);

        return $output . "\n";
    }

    public function __isset(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function __get(mixed $offset): mixed
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function __set(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function __unset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    public function count(): int
    {
        return count($this->data);
    }

    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->data);
    }

    public function toArray(): array
    {
        return $this->data;
    }

    /**
     * Removes all key value pairs.
     *
     * @return Collection
     */
    public function clear(): static|self
    {
        $this->data = [];

        return $this;
    }

    /**
     * Get all or a subset of matching key value pairs.
     *
     * @param array $keys Pass an array of keys to retrieve only a subset of key value pairs
     *
     * @return array Returns an array of all matching key value pairs
     */
    public function getAll(?array $keys = null): array
    {
        return $keys ? array_intersect_key($this->data, array_flip($keys)) : $this->data;
    }

    /**
     * Get a specific key value.
     *
     * @param string $key key to retrieve
     *
     * @return mixed|null Value of the key or NULL
     */
    public function get(string $key): mixed
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    /**
     * Set a key value pair.
     *
     * @param string $key Key to set
     * @param mixed $value Value to set
     *
     * @return Collection Returns a reference to the object
     */
    public function set(string $key, mixed $value): static|self
    {
        $this->data[$key] = $value;

        return $this;
    }

    /**
     * Add a value to a key.  If a key of the same name has already been added, the key value will be converted into an
     * array and the new value will be pushed to the end of the array.
     *
     * @param string $key Key to add
     * @param mixed $value Value to add to the key
     *
     * @return Collection returns a reference to the object
     */
    public function add(string $key, mixed $value): static|self
    {
        if (! array_key_exists($key, $this->data)) {
            $this->data[$key] = $value;
        } elseif (is_array($this->data[$key])) {
            $this->data[$key][] = $value;
        } else {
            $this->data[$key] = [$this->data[$key], $value];
        }

        return $this;
    }

    /**
     * Remove a specific key value pair.
     *
     * @param string $key A key to remove
     *
     * @return Collection
     */
    public function remove(string $key): static|self
    {
        unset($this->data[$key]);

        return $this;
    }

    /**
     * Get all keys in the collection.
     */
    public function getKeys(): array
    {
        return array_keys($this->data);
    }

    /**
     * Returns whether or not the specified key is present.
     *
     * @param string $key the key for which to check the existence
     */
    public function hasKey(string $key): bool
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Case insensitive search the keys in the collection.
     *
     * @param string $key Key to search for
     *
     * @return bool|string Returns false if not found, otherwise returns the key
     */
    public function keySearch(string $key): bool|string
    {
        foreach (array_keys($this->data) as $k) {
            if (! strcasecmp($k, $key)) {
                return $k;
            }
        }

        return false;
    }

    /**
     * Checks if any keys contains a certain value.
     *
     * @param mixed $value Value to search for
     *
     * @return mixed returns the key if the value was found FALSE if the value was not found
     */
    public function hasValue(mixed $value): mixed
    {
        return array_search($value, $this->data);
    }

    /**
     * Replace the data of the object with the value of an array.
     *
     * @param array $data Associative array of data
     *
     * @return Collection Returns a reference to the object
     */
    public function replace(array $data): static|self
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Add and merge in a Collection or array of key value pair data.
     *
     * @param Collection|array $data Associative array of key value pair data
     *
     * @return Collection returns a reference to the object
     */
    public function merge(array $data): static|self
    {
        foreach ($data as $key => $value) {
            $this->add($key, $value);
        }

        return $this;
    }

    /**
     * Over write key value pairs in this collection with all of the data from an array or collection.
     *
     * @param array|\Traversable $data Values to override over this config
     */
    public function overwriteWith(array|\Traversable $data): static|self
    {
        if (is_array($data)) {
            $this->data = $data + $this->data;
        } else {
            foreach ($data as $key => $value) {
                $this->data[$key] = $value;
            }
        }

        return $this;
    }

    /**
     * Returns a Collection containing all the elements of the collection after applying the callback function to each
     * one. The Closure should accept three parameters: (string) $key, (string) $value, (array) $context and return a
     * modified value.
     *
     * @param \Closure $closure Closure to apply
     * @param array $context Context to pass to the closure
     * @param bool $static Set to TRUE to use the same class as the return rather than returning a Collection
     *
     * @return Collection
     */
    public function map(\Closure $closure, array $context = [], bool $static = true): static|self
    {
        $collection = $static ? new static() : new self();
        foreach ($this as $key => $value) {
            $collection->add($key, $closure($key, $value, $context));
        }

        return $collection;
    }

    /**
     * Iterates over each key value pair in the collection passing them to the Closure. If the  Closure function returns
     * true, the current value from input is returned into the result Collection.  The Closure must accept three
     * parameters: (string) $key, (string) $value and return Boolean TRUE or FALSE for each value.
     */
    public function filter(\Closure $closure, bool $static = true): static|self
    {
        $collection = ($static) ? new static() : new self();
        foreach ($this->data as $key => $value) {
            if ($closure($key, $value)) {
                $collection->add($key, $value);
            }
        }

        return $collection;
    }

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->data[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return isset($this->data[$offset]) ? $this->data[$offset] : null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->data[$offset] = $value;
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->data[$offset]);
    }

    /**
     * Set a value into a nested array key. Keys will be created as needed to set the value.
     *
     * @param string $path Path to set
     * @param mixed $value Value to set at the key
     *
     * @throws \RuntimeException when trying to setPath using a nested path that travels through a scalar value
     */
    public function setPath(string $path, mixed $value): static|self
    {
        $current = &$this->data;
        $queue = explode('/', $path);
        $queueSize = count($queue);

        foreach ($queue as $index => $key) {
            if (! is_array($current)) {
                throw new \RuntimeException("Trying to setPath {$path}, but {$key} is set and is not an array");
            } elseif ($index === $queueSize - 1) {
                $current[$key] = $value;
            } elseif (isset($current[$key])) {
                $current = &$current[$key];
            } else {
                $current[$key] = [];
                $current = &$current[$key];
            }
        }

        return $this;
    }

    /**
     * Gets a value from the collection using an array path (e.g. foo/baz/bar would retrieve bar from two nested arrays)
     * Allows for wildcard searches which recursively combine matches up to the level at which the wildcard occurs. This
     * can be useful for accepting any key of a sub-array and combining matching keys from each diverging path.
     *
     * @param string $path Path to traverse and retrieve a value from
     * @param string $separator Character used to add depth to the search
     * @param mixed $data Optional data to descend into (used when wildcards are encountered)
     */
    public function getPath(array|string $path, string $separator = '/', mixed $data = null): mixed
    {
        if ($data === null) {
            $data = &$this->data;
        }

        $path = is_array($path) ? $path : explode($separator, $path);

        foreach ($path as $part) {
            if (! is_array($data)) {
                return null;
            } elseif (isset($data[$part])) {
                $data = &$data[$part];
            } elseif ($part != '*') {
                return null;
            } else {
                // Perform a wildcard search by diverging and merging paths
                $result = [];
                foreach ($data as $value) {
                    if (! $path) {
                        $result = array_merge_recursive($result, (array) $value);
                    } elseif (null !== ($test = $this->getPath($path, $separator, $value))) {
                        $result = array_merge_recursive($result, (array) $test);
                    }
                }
                return $result;
            }
        }

        return $data;
    }
}
