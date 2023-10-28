<?php

namespace app\utils;

class Other{
    static function Search($key,$arr,$arr_key=null,$like=true){
        $results = [];
        if($arr && count($arr)){
            foreach ($arr as $item) {
                foreach ($item as $k => $val) {
                    if((($arr_key && $k==$arr_key) || !$arr_key)){
                        if($like && $val && gettype($key)!='boolean'){
                            if(strpos(strtolower($val), strtolower($key)) !== false) $results[] = $item;
                        }else{
                            if($val === $key) $results[] = $item;
                        }
                    }
                }
            }
        }
        return $results;
    }


    // 生成指定长度随机字符串
    static function randomStr($length=5){
        // 密码字符集，可任意添加你需要的字符
        $chars = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
        $str = '';
        for ( $i = 0; $i < $length; $i++ ){
            $str .= $chars[mt_rand(0,count($chars)-1)];
        }
        return $str;
    }
}
