<?php

namespace app\utils;

class File{
    static function Upload(){
        $file = request()->file('file');
        $mime = $file->getOriginalMime();
        $type = explode('/',$mime)[0];
        $path = '/static/';
        switch ($type) {
            case 'image':
                $path .= 'image/';
                break;
            case 'video':
                $path .= 'video/';
                break;
            default:
                $path .= 'other/';
                break;
        }
        $path .= date('Y-m-d').'/';
        $name = $file->getOriginalName();
        $info = [
            'mime' => $mime,
            'size' => $file->getSize(),
            'extension' => $file->extension(),
            'name' => $name,
            'type' => $type,
            'path' => $path.$name,
            'url' => request()->domain().$path.$name,
        ];

        $file->move('./public'.$path,$name);
        return $info;
    }
}