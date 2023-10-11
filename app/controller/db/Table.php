<?php

namespace app\controller\db;

use app\controller\Base;
use app\api\db\TableApi;
use app\utils\Table as UtTable;

class Table extends Base
{
    function List(){
        $data = TableApi::Get(TableApi::$List);
        if($data['name'] && UtTable::TableIfExists($data['name'])) $res1 = [$data['name']];
        else $res1 = [];
        if($data['comment']) $res2 = UtTable::CommGetTable($data['comment']);
        else $res2 = [];
        if($res1 && $res2)  $res = array_intersect($res1, $res2);
        else if($res1) $res = $res1;
        else if($res2) $res = $res2;
        else $res = [];
      
        if(!$res) $res = UtTable::TableList();
        $list['data'] = [];
        if($res && count($res)){
            foreach ($res as $value) {
                $list['data'][] = ['name'=>$value,'comment'=>UtTable::TableComm($value)];
            }
        }
        return self::Success('获取完成',$list);
    }

    function Add(){
        $data = TableApi::Get(TableApi::$Add);
        if(UtTable::TableIfExists($data['name'])) throw new \Exception('数据表已存在');
        UtTable::AddTable($data['name'],$data['comment']);
        return self::Success('添加成功');
    }

    function Edit(){
        $data = TableApi::Get(TableApi::$Edit);
        UtTable::EditTable($data['oldname'],$data['name'],$data['comment']);
        return self::Success('更新成功');
    }

    function Del(){
        $data = TableApi::Get(TableApi::$Del);
        $data['name'] = self::DataToAarray($data['name']);
        if($data['name'] && count($data['name'])){
            foreach ($data['name'] as $value) {
                UtTable::DelTable($value);
            }
        }
        return self::Success('删除成功');
    }
}