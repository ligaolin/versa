<?php

namespace app\utils;

use think\facade\Cache;

class Client
{
    static function Name($key)
    {
        return $_SERVER['REMOTE_ADDR'] . '.' . $key;
    }

    // 设置缓存
    static function Set($key, $val, $ttl = null)
    {
        Cache::set(self::Name($key), $val, $ttl);
    }

    // 获取缓存
    static function Get($key, $default = null)
    {
        return Cache::get(self::Name($key), $default);
    }
}
