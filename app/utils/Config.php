<?php

namespace app\utils;
use think\facade\Db;

class Config{
    static function ListByName($name){
        $list = Db::name('config')->where('name','in',$name)->select();
        $res = [];
        foreach ($list as $v) {
            if($v['type']=='上传图片'||$v['type']=='上传视频'||$v['type']=='上传文件') $v['val'] = json_decode($v['val']);
            $res[$v['name']] = $v['val'];
        }
        return $res;
    }

    static function GetByName($name){
        $find = Db::name('config')->where('name',$name)->find();
        if($find['type']=='上传图片'||$find['type']=='上传视频'||$find['type']=='上传文件') $find['val'] = json_decode($find['val']);
        return $find['val'];
    }
}