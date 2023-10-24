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

    function __construct(){
        $time = time()-intval(env('JWT_EXPIR'));
        self::Db('user_token')->where('created_at','<',date('Y-m-d H:i:s',$time))->delete();
    }

    function Get(){
        $data = UserApi::Get(UserApi::$Get);
        $where = self::Where($data,[
            ['name'=>'user.id','type'=>'in'],
            ['name'=>'user.name','type'=>'in'],
            ['name'=>'group_name','type'=>'in','key'=>'user_group.name'],
        ]);
        if($res['data'] = self::Db()->where($where)->leftJoin('user_group','user_group.id = user.user_group_id')->field('user.*,user_group.name as group_name')->find()) unset($res['data']['password']);
        return self::Success('获取完成',$res);
    }

    function List(){
        $data = UserApi::Get(UserApi::$List);
        $where = self::Where($data,[
            ['name'=>'user.id','type'=>'in'],
            ['name'=>'user.name','type'=>'like'],
            ['name'=>'user.type','type'=>'like'],
            ['name'=>'user.user_group_id','type'=>'like'],
            ['name'=>'user.state','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where)->leftJoin('user_group','user_group.id = user.user_group_id')->field('user.*,user_group.name as group_name'),$data);
        foreach ($res['data'] as $k => $v) {
            unset($res['data'][$k]['password']);
        }
        return self::Success('获取完成',$res);
    }

    static private function EditRole($type){
        $update = $data = UserApi::Get(UserApi::$Edit);
        unset($update['id']);
        unset($update['password']);
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

    function AdminEdit()
    {
        return self::EditRole('管理员');
    }
    function AdminChange()
    {
        return self::Change(['type'=>'管理员']);
    }
    function AdminDel()
    {
        return self::Del(['type'=>'管理员']);
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

        if($token){
            self::Db('user_token')->insertGetId(['user_id'=>$find['id'],'token'=>$token]);
            return self::Success('登录成功',['data'=>$find,'token'=>$token]);
        } else return self::Error('生成身份验证信息出错');
    }

    function Me(){
        $data['data'] = request()->user;
        unset($data['data']['password']);
        return self::Success('获取成功',$data);
    }

    function AdminLoginOut(){
        self::Db('user_token')->where('token',request()->token)->delete();
        return self::Success('退出登录成功');
    }
}
