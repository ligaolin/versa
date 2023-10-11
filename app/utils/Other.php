<?php

namespace app\utils;

class Other{
    static function Search($key,$arr,$arr_key=null){
        $results = [];
        if($arr && count($arr)){
            foreach ($arr as $k => $item) {
                if(($arr_key && $k==$arr_key) || !$arr_key){
                    if (strpos($item, $key) !== false) $results[] = $item;
                }
            }
        }
        return $results;
    }
}