<?php

namespace app\utils;

class File{
    static function Upload(){
        $file = request()->file('file');
        $mime = $file->getOriginalMime();
        $type = explode('/',$mime)[0];
        $dir = 'static/';
        switch ($type) {
            case 'image':
                $dir .= 'image/';
                break;
            case 'video':
                $dir .= 'video/';
                break;
            default:
            $dir .= 'other/';
                break;
        }
        $dir .= date('Y-m-d').'/';
        $extension = $file->extension();
        $fileName = time().rand(1000, 9999).'.'.$extension;
        $path =  '/'.$dir.$fileName;
        $info = [
            'mime' => $mime,
            'size' => $file->getSize(),
            'extension' => $extension,
            'name' => $file->getOriginalName(),
            'type' => $type,
            'path' => $path,
            'url' => request()->domain().$path,
        ];

        $file->move($dir,$fileName);
        return $info;
    }
}