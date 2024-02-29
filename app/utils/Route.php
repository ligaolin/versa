<?php

namespace app\utils;

use think\facade\Route as TpRoute;

class Route
{
    static function SetRoute($app,$arr)
    {
        // TpRoute::group(function () use ($app,$arr) {
            foreach ($arr as $v) {
                if (isset($v['action']) && $v['action']) {
                    if (isset($v['base']) && count($v['base'])) self::Route($app,$v, 'base');

                    if (isset($v['admin']) && count($v['admin'])) {
                        TpRoute::group('admin', function () use ($app,$v) {
                            self::Route($app,$v, 'admin');
                        })->middleware(\app\middleware\Admin::class);
                    }
                }
            }
        // })->allowCrossDomain();
    }

    static function Route($app,$data, $type)
    {
        foreach ($data[$type] as $v1) {
            $path = 'app/'.$app.'/'.($type!='base'?$type.'/':'').$data['action'].'/'. $v1;
            $data['action'] = explode('.',$data['action']);
            $data['action'] = implode('\\',$data['action']);
            $class = '\app\\'.$app.'\controller\\'.$data['action'].'::'.$v1;
            if (isset($data['method']) && $data['method']) {
                TpRoute::rule($path, $class, strtoupper($data['method']));
            } else {
                TpRoute::rule($path, $class);
            }
        }
    }
}
