<?php

namespace app\controller\user;

use app\controller\Base;
use app\api\user\UserGroupApi;

class UserGroup extends Base
{
    static $table = 'user_group';
    static $changeField = ['name','sort','state'];

    function Get(){
        $data = UserGroupApi::Get(UserGroupApi::$Get);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'in'],
        ]);
        return self::Success('获取完成',self::Db()->where($where)->find());
    }

    function List(){
        $data = UserGroupApi::Get(UserGroupApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'auth_ids','type'=>'like'],
            ['name'=>'state','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where),$data);
        return self::Success('获取完成',$res);
    }

    function Edit()
    {
        $update = $data = UserGroupApi::Get(UserGroupApi::$Edit);
        unset($update['id']);

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
