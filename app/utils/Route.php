<?php

namespace app\utils;

use think\facade\Route as TpRoute;

class Route
{
    static function SetRoute($app,$arr)
    {
        TpRoute::group(function () use ($app,$arr) {
            foreach ($arr as $v) {
                if (isset($v['action']) && $v['action']) {
                    if (isset($v['base']) && count($v['base'])) self::Route($app,$v['base'],$v['action']);
                    if (isset($v['admin']) && count($v['admin'])) {
                        TpRoute::group(function () use ($app,$v) {
                            self::Route($app,$v['admin'],$v['action'],'admin');
                        })->middleware(\app\middleware\Admin::class);
                    }
                }
            }
        })->allowCrossDomain();
    }

    static function Route($app,$data,$action,$type='')
    {
        foreach ($data as $v1) {
            $path = 'app/'.$app.'/'.($type?$type.'/':'').$action.'/'. $v1;
            $class = '\app\\'.$app.'\controller\\'.implode('\\',explode('.',$action)).'::'.$v1;
            if (isset($data['method']) && $data['method']) {
                TpRoute::rule($path, $class, strtoupper($data['method']));
            } else {
                TpRoute::rule($path, $class);
            }
        }
    }
}
