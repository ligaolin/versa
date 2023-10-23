<?php

namespace app\controller\user;

use app\controller\Base;
use app\api\user\UserAuthApi;

class UserAuth extends Base
{
    static $table = 'user_auth';
    static $changeField = ['name','route','sort','state'];

    function Get(){
        $data = UserAuthApi::Get(UserAuthApi::$Get);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'in'],
            ['name'=>'route','type'=>'in'],
        ]);
        return self::Success('获取完成',self::Db()->where($where)->find());
    }

    function List(){
        $data = UserAuthApi::Get(UserAuthApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'pid','type'=>'in'],
            ['name'=>'level','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'route','type'=>'in'],
            ['name'=>'state','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where),$data);
        return self::Success('获取完成',$res);
    }

    function Edit($type)
    {
        $update = $data = UserAuthApi::Get(UserAuthApi::$Edit);
        unset($update['id']);
        if($data['pid']) $update['level'] = self::Db()->where('id = '.$data['pid'])->value('level')+1;
        $update['type'] = $type;

        if($data['id']){
            if(self::Db()->where('name',$data['name'])->where('id','<>',$data['id'])->where('type',$type)->count()) throw new \Exception('同级已有相同权限名');

            if(self::Db()->where('route',$data['route'])->where('id','<>',$data['id'])->where('type',$type)->count()) throw new \Exception('同级已有相同路由');

            // 更新
            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新完成');
        }else{
            if(self::Db()->where('name',$data['name'])->where('type',$type)->count()) throw new \Exception('同级已有相同权限名');

            if(self::Db()->where('route',$data['route'])->where('type',$type)->count()) throw new \Exception('同级已有相同路由');

            // 添加
            if($id = self::Db()->insertGetId($update)) return self::Success('添加成功',$id);
            else return self::Error('添加失败');
        }

        return self::ResData($data);
    }
    

    function AdminEdit()
    {
        self::Edit('管理员');
    }

    function AdminChange()
    {
        self::Change(['type'=>'管理员']);
    }

    function AdminDel()
    {
        self::Del(['type'=>'管理员']);
    }
}
