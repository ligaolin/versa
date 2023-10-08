<?php

namespace app\utils;

use SimpleCaptcha\Builder;

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
        Client::Set('Captcha', $builder->phrase,300);

        return response($builder->output(), 200, ['Content-type' => 'image/jpeg']);
    }

    static function Check($code){
        if(!$code) return false;
        $data = Client::Get('Captcha');
        if(strtolower($code) == strtolower($data)) return true;
        else return false;
    }
}