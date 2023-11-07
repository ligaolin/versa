<?php

namespace app\controller\other;

use app\controller\Base;
use app\utils\File as UtFile;
use app\api\other\FileApi;
use app\utils\Other;

class File extends Base
{
    function List(){
        $data = FileApi::Get(FileApi::$List);
        $res['data'] = UtFile::List($data['dir']);
        if($data['name']) $res['data'] = Other::Search($data['name'],$res['data'],'name');
        $res['total'] = count($res['data']);
        return self::Success('获取成功',$res);
    }

    function Del(){
        $data = FileApi::Get(FileApi::$Del);
        $paths = self::DataToAarray($data['path']);
        $base = basename($_SERVER['DOCUMENT_ROOT']);
        foreach ($paths as $v) {
            if($base=='public') $v = 'public/'.$v;
            UtFile::Del($v);
        }
        return self::Success('删除成功');
    }

    function Change($where=[]){
        $data = FileApi::Get(FileApi::$Change);
        $base = basename($_SERVER['DOCUMENT_ROOT']);
        if($base=='public') $data['path'] = 'public/'.$data['path'];
        UtFile::Change($data['path'],$data['newName']);
        return self::Success('更新成功');
    }

    function Add(){
        $data = FileApi::Get(FileApi::$Add);
        $base = basename($_SERVER['DOCUMENT_ROOT']);
        if($base=='public') $data['path'] = 'public/'.$data['path'];
        UtFile::AddDir($data['path'],$data['name']);
        return self::Success('添加成功');
    }
}