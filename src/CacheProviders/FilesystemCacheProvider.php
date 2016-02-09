<?php

namespace CacheProviders;

use Interfaces\CacheProvider;

class FilesystemCacheProvider implements CacheProvider
{
    private $cacheTtl;

    public function __construct($folder, $cacheTtl)
    {
        \FileSystemCache::$cacheDir = $folder;
        $this->cacheTtl = $cacheTtl;
    }

    public function setCache($key, $data)
    {
        $cacheKey = \FileSystemCache::generateCacheKey($key);
        return \FileSystemCache::store($cacheKey, $data, $this->cacheTtl);
    }

    public function getCache($key)
    {
        $cacheKey = \FileSystemCache::generateCacheKey($key);
        return \FileSystemCache::retrieve($cacheKey);
    }
}
 