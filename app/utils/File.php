<?php

namespace app\utils;

class File{
    static function Write($path,$data){
        $handle = fopen($path, 'a') or die('Cannot open file:  '.$path);
        fwrite($handle, $data);
        fclose($handle);
    }

    static function Read($path,$func){
        $handle = fopen($path, "r");
        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                $func($line);
            }
            fclose($handle);
        }
    }
}