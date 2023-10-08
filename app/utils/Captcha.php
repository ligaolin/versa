<?php

namespace app\utils;

use SimpleCaptcha\Builder;
use think\facade\Cache;

class Captcha {
    static function Set($width=100,$height=41){
        if(!$width) $width = 100;
        if(!$height) $height = 41;
        $builder = new Builder;
        $builder = Builder::create($builder->buildPhrase(4));
        $builder->bgColor = [243, 251, 254];
        $builder->applyEffects = false;
        $builder->build($width,$height);

        // 设置缓存
        Cache::set('Captcha', self::Cache($builder->phrase));

        return response($builder->output(), 200, ['Content-type' => 'image/jpeg']);
    }

    static function Check($code){
        if(!$code) return false;
        $data = self::Cache();
        if(array_key_exists(strtolower($code),$data)) return true;
        else return false;
    }

    static function Cache($add=''){
        $cache = Cache::get('Captcha');
        $time = time();
        if($add) $data = [strtolower($add)=>$time];
        else $data = [];
        if($cache){
            foreach($cache as $key => $val){
                if(intval($val)+300 > $time) $data[$key] = $val;
            }
        }
        return $data;
    }
}