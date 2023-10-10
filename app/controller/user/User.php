<?php

namespace app\controller\user;

use app\controller\Base;
use app\api\user\UserApi;
use app\utils\Captcha;
use Firebase\JWT\JWT;

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

    static private function EditRole($type){
        $update = $data = UserApi::Get(UserApi::$Edit);
        unset($update['id']);
        unset($update['duplicatePassword']);
        if($update['avatar']) $update['avatar'] = json_encode($update['avatar']);
        $update['type'] = $type;

        if(!$data['id'] || $data['password']){
            if(!$data['password']) throw new \Exception('密码必须');
            if(!$data['duplicatePassword']) throw new \Exception('重复密码必须');
            if($data['password']!=$data['duplicatePassword']) throw new \Exception('两次密码不一样');
            // 密码加密
            $update['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if($data['id']){
            if(self::Db()->where('name',$data['name'])->where('id','<>',$data['id'])->where('type',$type)->count()) throw new \Exception('管理员已存在');
            // 更新
            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新完成');
        }else{
            if(self::Db()->where('name',$data['name'])->where('type',$type)->count()) throw new \Exception('管理员已存在');
            // 添加
            if($id = self::Db()->insertGetId($update)) return self::Success('添加成功',$id);
            else return self::Error('添加失败');
        }
    }

    function Edit()
    {
        return self::EditRole('管理员');
    }

    function AdminLogin(){
        $data = UserApi::Get(UserApi::$AdminLogin);
        if (!Captcha::Check($data['code'])) throw new \Exception('验证码错误');

        if(!$find = self::Db()->where('type = "管理员" AND name = "'.$data['name'].'"')->find()) throw new \Exception('管理员不存在');

        if(!password_verify($data['password'],$find['password'])) throw new \Exception('密码错误');
        unset($find['password']);

        $token= JWT::encode([
            'id'=>$find['id'],
            'time'=>time(),
        ],env('JWT_KEY'), 'HS256');
        if($token) return self::Success('登录成功',['data'=>$find,'token'=>$token]);
        else return self::Error('生成身份验证信息出错');
    }
}
