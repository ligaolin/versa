<?php

namespace app\controller\db;

use app\controller\Base;
use app\api\db\FieldApi;
use app\utils\Table as UtTable;
use app\utils\Other;

class Field extends Base
{
    function List(){
        $data = FieldApi::Get(FieldApi::$List);
        $res['data'] = UtTable::FieldList($data['table']);
        foreach ($res['data'] as $k => $v) {
            $res['data'][$k] = [
                'name' => $v['Field'],
                'type' => $v['Type'],
                'isNull' => $v['Null']=='YES'?true:false,
                'default' => $v['Default'],
                'key' => $v['Key'],
                'comment' => $v['comment'],
            ];
        }

        if($data['name']) $res['data'] = Other::Search($data['name'],$res['data'],'name');
        if($data['type']) $res['data'] = Other::Search($data['type'],$res['data'],'type');
        if($data['isNull'] || $data['isNull']===false) $res['data'] = Other::Search($data['isNull'],$res['data'],'isNull');
        if($data['default']!=='') $res['data'] = Other::Search($data['default'],$res['data'],'default');
        if($data['comment']) $res['data'] = Other::Search($data['comment'],$res['data'],'comment');
        if($data['key']) $res['data'] = Other::Search($data['key'],$res['data'],'key');
   
        return self::Success('获取完成',$res);
    }

    function Add(){
        $data = FieldApi::Get(FieldApi::$Add);
        if(!UtTable::TableIfExists($data['table'])) throw new \Exception('数据表不存在');
        if(UtTable::FieldIfExists($data['table'],$data['name'])) throw new \Exception('表字段已存在');

        UtTable::AddField($data['table'],$data['name'],$data['type'],$data['isNull'],$data['default'],$data['comment'],$data['key']);
        return self::Success('添加成功');
    }

    function Edit(){
        $data = FieldApi::Get(FieldApi::$Edit);
         
        if(!UtTable::TableIfExists($data['table'])) throw new \Exception('数据表不存在');
        if(!UtTable::FieldIfExists($data['table'],$data['oldName'])) throw new \Exception('表字段不存在');

        UtTable::AlterField($data['table'],$data['oldName'],$data['name'],$data['type'],$data['isNull'],$data['default'],$data['comment'],$data['key']);
        return self::Success('更新成功');
    }

    function Del($data=[]){
        $data = FieldApi::Get(FieldApi::$Del);
        if(!UtTable::TableIfExists($data['table'])) throw new \Exception('数据表不存在');
        if(!UtTable::FieldIfExists($data['table'],$data['name'])) throw new \Exception('表字段不存在');
        UtTable::DelField($data['table'],$data['name']);
        return self::Success('删除成功');
    }
}