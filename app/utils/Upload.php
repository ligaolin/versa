<?php

namespace app\utils;

class Upload{
    static function Upload($dir=''){
        try{
            $file = request()->file('file');
            $mime = $file->getOriginalMime();
            $type = explode('/',$mime)[0];
            $extension = $file->extension();
            $size = $file->getSize();
            $name = $file->getOriginalName();

            self::checkSize($size,$type);
            self::checkExt($extension);

            $base = basename($_SERVER['DOCUMENT_ROOT']);

            if($dir){
                if(substr($dir, 0, 6) != "static") $dir = 'static'.$dir;
                if(substr_count($dir, '/') >= 7) throw new \Exception('文件夹层级过多');
                if(strpos($dir,'..')) throw new \Exception('不允许的文件路径');
                $fileName = $name;

                $dir1 = $dir;
                if (file_exists($dir1.'/'.$fileName)) throw new \Exception('文件已存在');
            }else{
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
                $fileName = time().rand(1000, 9999).'.'.$extension;
            }
            $path =  '/'.$dir.$fileName;
            $info = [
                'mime' => $mime,
                'size' => $size,
                'extension' => $extension,
                'name' => $name,
                'type' => $type,
                'path' => $path,
                'url' => request()->domain().$path,
            ];
            $file->move($dir,$fileName);
            return $info;
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    // 核对大小
    static function checkSize($size,$type){
        $config = Config::ListByName(['图片最大限制（M）','视频最大限制（M）','其他最大限制（M）']);
        switch($type){
            case 'image':
                $max_size = $config['图片最大限制（M）'];
                break;
            case 'video':
                $max_size = $config['视频最大限制（M）'];
                break;
            default:
                $max_size = $config['其他最大限制（M）'];
                break;
        }
        $max_size_byte = intval($max_size) * 1024 * 1024;
        if($size > $max_size_byte) throw new \Exception('文件不能超过'.$max_size.'M');
    }

    // 核对格式限制
    static function checkExt($ext){
        $format = Config::GetByName('可上传类型');
        $format = explode(',',$format);
        foreach ($format as $k => $v) {
            $format[$k] = strtolower($v);
        }
        if(!in_array(strtolower($ext),$format)) throw new \Exception('该文件格式不能上传');
    }
}