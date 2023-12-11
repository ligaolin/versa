<?php

namespace app\utils;

class File{
    static function List($dir='static'){
        if(!$dir) $dir='static';
        $dir1 = $dir;
        $contents = scandir($dir);
        $arr = [];
        // 遍历文件夹内容
        foreach ($contents as $item) {
            if ($item != "." && $item != "..") {
                $path = $dir1.'/'.$item;
                $file = $dir.'/'.$item;
                if (is_dir($dir . "/" . $item)) {
                    $arr[] = self::dirInfo($path,$item);
                } else {
                    $arr[] = self::fileInfo($file,$path,$item);
                }
            }
        }
        return $arr;
    }

    static function fileInfo($file,$path,$name){
        return [
            'mime' => mime_content_type($file),
            'size' => filesize($file),
            'extension' => pathinfo($file, PATHINFO_EXTENSION),
            'type' => explode('/',mime_content_type($file))[0],
            'name' => $name,
            'path' => $path,
            'url' => request()->domain().'/'.$path,
            'fileOrDir' => '文件',
        ];
    }

    static function dirInfo($path,$name){
        return [
            'type'=>'dir',
            'name'=>$name,
            'path'=>$path,
            'url'=>request()->domain().'/'.$path,
            'fileOrDir' => '文件夹',
        ];
    }

    static function Del($path){
        // 检查文件夹是否存在
        if (is_dir($path)) {
            // 打开文件夹
            $handle = opendir($path);
            // 遍历文件夹中的文件和子文件夹
            while (($file = readdir($handle)) !== false) {
                if ($file != "." && $file != "..") {
                    $filePath = $path . '/' . $file;

                    // 如果是文件，则直接删除
                    if (is_file($filePath)) {
                        unlink($filePath);
                    }
                    // 如果是子文件夹，则递归调用删除函数
                    elseif (is_dir($filePath)) {
                        self::Del($filePath);
                    }
                }
            }
            // 关闭文件夹
            closedir($handle);

            // 删除空的文件夹
            if (!rmdir($path)) throw new \Exception('删除失败');
        }else if (is_file($path)) {
            if (!unlink($path)) throw new \Exception('删除失败');
        } else throw new \Exception('路径不存在');
    }

    static function Change($path,$newName){
        if (!file_exists($path)) throw new \Exception('路径不存在');
        $newPath = str_replace(basename($path), '', $path);
        if (!rename($path, $newPath.'/'.$newName)) throw new \Exception('修改失败');
    }

    static function AddDir($path,$name){
        if (file_exists($path.'/'.$name)) throw new \Exception('路径已存在');
        mkdir($path.'/'.$name, 0777, true);
    }
}