<?php

namespace app\utils;

use think\facade\Route as TpRoute;

class Route
{
    static function SetRoute($arr)
    {
        TpRoute::group('api', function () use ($arr) {
            foreach ($arr as $v) {
                if (isset($v['action']) && $v['action']) {
                    if (isset($v['base']) && count($v['base'])) {
                        self::Route($v, 'base');
                    }

                    if (isset($v['admin']) && count($v['admin'])) {
                        TpRoute::group('admin', function () use ($v) {
                            self::Route($v, 'admin');
                        })->middleware(\app\middleware\Admin::class);
                    }
                }
            }
        })->allowCrossDomain();
    }

    static function Route($data, $type)
    {
        foreach ($data[$type] as $v1) {
            $path = $data['action'] . '/' . $v1;
            if (isset($data['method']) && $data['method']) {
                TpRoute::rule($path, $path, strtoupper($data['method']));
            } else {
                TpRoute::rule($path, $path);
            }
        }
    }
}
