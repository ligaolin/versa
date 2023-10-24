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
}