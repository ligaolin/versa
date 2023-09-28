<?php

namespace app\controller\user;

use app\controller\Base;
use app\api\user\UserAuthApi;
use app\model\UserAuth as UserAuthModel;

class UserAuth extends Base
{
    static $table = 'user_auth';

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

    function Edit()
    {
        $update = $data = UserAuthApi::Get(UserAuthApi::$Edit);
        unset($update['id']);
        if($data['pid']) $update['level'] = self::Db()->where('id = '.$data['pid'])->value('level')+1;

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
