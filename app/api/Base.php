<?php

namespace app\api;

use think\exception\ValidateException;

class Base{
    static function rule(){ return []; }

    static function Get(){
        $param = input();
        $data = [];
        foreach ($param as $key => $value) {
            if(property_exists(static::class,$key) && $key!='verify'){
                static::$$key = $value;
                $data[$key] = $value;
            }
        }
        self::Validate($data); // 验证
        return $data;
    }

    static function Validate($data){
        $ruleArr = [];
        $msgArr = [];
        foreach(static::rule() as $v){
            if(is_array($v) && count($v)>=2 && is_array($v[1]) && count($v[1])){
                foreach($v[1] as $k1 => $v1){
                    if(is_array($v1) && count($v1)){
                        // 验证规格
                        if(!$k1) $ruleArr[$v[0]] = $v1[0];
                        else $ruleArr[$v[0]] .= '|'.$v1[0];
                        // 错误信息
                        $rule = explode(':',$v1[0]);
                        $msgArr[$v[0].'.'.$rule[0]] = $v1[1];
                    }
                }
            }
        }

        try{
            validate($ruleArr,$msgArr)->check($data);
        } catch (ValidateException $e) {
            // 验证失败 输出错误信息
            throw new \Exception($e->getError());
        }
    }
}