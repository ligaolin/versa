<?php

namespace app\controller\db;

use app\controller\Base;
use app\api\db\FieldApi;
use app\utils\Table as UtTable;

class Field extends Base
{
    function List(){
        $data = FieldApi::Get(FieldApi::$List);
        $res = UtTable::FiledList($data['name']);
        return self::Success('获取完成',$res);
    }

    function Edit(){
        $update = $data = FieldApi::Get(FieldApi::$Edit);
        unset($update['id']);

        if($data['id']){ // 更新
            if(self::Db()->where('name',$data['name'])->where('id','<>',$data['id'])->count()) throw new \Exception('已存在');

            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新完成');
        }else{ // 添加
            if(self::Db()->where('name',$data['name'])->count()) throw new \Exception('已存在');

            if($id = self::Db()->insertGetId($update)) return self::Success('添加成功',$id);
            else return self::Error('添加失败');
        }
    }
}