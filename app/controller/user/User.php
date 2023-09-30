<?php

namespace app\controller\user;

use app\controller\Base;
use app\api\user\UserApi;

class User extends Base
{
    static $table = 'user';
    static $changeField = ['name','sort','state'];

    function Get(){
        $data = UserApi::Get(UserApi::$Get);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'in'],
        ]);
        return self::Success('获取完成',self::Db()->where($where)->find());
    }

    function List(){
        $data = UserApi::Get(UserApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'type','type'=>'like'],
            ['name'=>'user_group_id','type'=>'like'],
            ['name'=>'state','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where),$data);
        return self::Success('获取完成',$res);
    }

    function Edit()
    {
        $update = $data = UserApi::Get(UserApi::$Edit);
        unset($update['id']);

        if($data['id'] || $data['password']){
            if(!$data['password']) throw new \Exception('密码必须');
            if(!$data['duplicatePassword']) throw new \Exception('重复密码必须');
            if($data['password']!=$data['duplicatePassword']) throw new \Exception('两次密码不一样');
            unset($update['duplicatePassword']);
            // 密码加密
            // crypt($data['password'],salt)
        }

        if($data['id']){
            // 更新
            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新完成');
        }else{
            // 添加
            if($id = self::Db()->insertGetId($update)) return self::Success('添加成功',$id);
            else return self::Error('添加失败');
        }

        return self::ResData($data);
    }
}
