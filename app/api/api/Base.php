<?php

namespace app\api;

use think\exception\ValidateException;

class Base{
    static function Get($data){
        $param = input();

        $arr = array_combine(array_column($data, 0), array_column($data, 1));
        foreach ($param as $key => $value) {
            if(array_key_exists($key,$arr) && $value!=='' && $value!==null) $arr[$key] = $value;
        }
        self::Validate($data,$arr); // 验证
        return $arr;
    }

    static function Validate($ruleData,$data){
        $ruleArr = [];
        $msgArr = [];
        foreach($ruleData as $v){
            if(is_array($v) && count($v)>=3){
                $rules = array_slice($v, 2, null, true);
                if(count($rules)){
                    foreach($rules as $k1 => $v1){
                        // 验证规格
                        if($k1==2) $ruleArr[$v[0]] = $v1[0];
                        else $ruleArr[$v[0]] .= '|'.$v1[0];

                        // 错误信息
                        $msg = explode(':',$v1[0]);
                        $msgArr[$v[0].'.'.$msg[0]] = $v1[1];
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