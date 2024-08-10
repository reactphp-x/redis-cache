<?php

namespace ReactphpX\RedisCache;

use React\Cache\CacheInterface;

class RedisCache implements CacheInterface
{
    private $redis;

    public function __construct($redis)
    {
        $this->redis = $redis;
    }

    public function get($key, $default = null)
    {
        return $this->redis->get($key)->then(function ($value) use ($default) {
            return $value ?? $default;
        }, function ($e) use ($default) {
            return $default;
        });
    }

    public function getMultiple($keys, $default = null)
    {
        return $this->redis->mget(...$keys)->then(function ($values) use ($keys, $default) {
            $result = [];
            foreach ($keys as $i => $key) {
                $result[$key] = $values[$i] ?? $default;
            }
            return $result;
        }, function ($e) use ($keys, $default) {
            return array_fill(0, count($keys), $default);
        });
    }

    public function set($key, $value, $ttl = null)
    {
        if ($ttl === null) {
            return $this->redis->set($key, $value);
        }
        return $this->redis->set($key, $value, 'EX', $ttl);
    }

    public function setMultiple($values, $ttl = null)
    {
        $args = [];
        foreach ($values as $key => $value) {
            $args[] = $key;
            $args[] = $value;
        }
        if ($ttl === null) {                      
            return $this->redis->mset(...$args);
        }
        $args[] = 'EX';
        $args[] = $ttl;
        return $this->redis->mset(...$args);

    }

    public function delete($key)
    {
        return $this->redis->del($key);
    }

    public function deleteMultiple($keys)
    {
        return $this->redis->del($keys);
    }

    public function clear()
    {
        // return $this->redis->flushDB();
    }

    public function has($key)
    {
        return $this->redis->exists($key);
    }
}
