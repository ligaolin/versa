<?php

namespace app\controller\setting;

use app\controller\Base;
use app\api\setting\AdminCateApi;

class AdminCate extends Base
{
    static $table = 'admin_cate';
    static $changeField = ['name','path','view','sort','state'];

    function Get(){
        $data = AdminCateApi::Get(AdminCateApi::$Get);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'in'],
        ]);
        $res['data'] = self::Db()->where($where)->find();
        return self::Success('获取完成',$res);
    }

    function List(){
        $data = AdminCateApi::Get(AdminCateApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'pid','type'=>'in'],
            ['name'=>'level','type'=>'in'],
            ['name'=>'type','type'=>'in'],
            ['name'=>'path','type'=>'name'],
            ['name'=>'view','type'=>'name'],
            ['name'=>'state','type'=>'in'],
            ['name'=>'show','type'=>'in'],
        ]);
        $cwhere = self::Where($data,[
            ['name'=>'childId','type'=>'in','key'=>'id'],
            ['name'=>'childName','type'=>'like','key'=>'name'],
            ['name'=>'childPid','type'=>'in','key'=>'pid'],
            ['name'=>'childLevel','type'=>'in','key'=>'level'],
            ['name'=>'childType','type'=>'in','key'=>'type'],
            ['name'=>'childPath','type'=>'name','key'=>'path'],
            ['name'=>'childView','type'=>'name','key'=>'view'],
            ['name'=>'childState','type'=>'in','key'=>'state'],
            ['name'=>'childShow','type'=>'in','key'=>'show'],
        ]);
        $res = self::GetList(self::Db()->where($where),$data,'','pid',$cwhere);
        $res['cwhere'] = $cwhere;
        return self::Success('获取完成',$res);
    }

    function GetListByPid(){
        $data = AdminCateApi::Get(AdminCateApi::$GetListByPid);
        $cwhere = self::Where($data,[
            ['name'=>'name','type'=>'like'],
            ['name'=>'level','type'=>'in'],
            ['name'=>'type','type'=>'in'],
            ['name'=>'path','type'=>'name'],
            ['name'=>'view','type'=>'name'],
            ['name'=>'state','type'=>'in'],
            ['name'=>'show','type'=>'in'],
        ]);
        $res['data'] = self::AllChildren($data['pid'],$cwhere);
        $res['all'] = self::AllChildren($data['pid']);
        return self::Success('获取完成',$res);
    }

    function Edit(){
        $update = $data = AdminCateApi::Get(AdminCateApi::$Edit);
        unset($update['id']);
        if($data['type'] == '页面'){
            if(!$data['path']) throw new \Exception('页面路由必须');
            if(!$data['view']) throw new \Exception('页面路径必须');
        }

        if($data['id']){ // 更新
            if(self::Db()->where('name',$data['name'])->where('id','<>',$data['id'])->where('pid',$data['pid'])->count()) throw new \Exception('名称已存在');

            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新完成');
        }else{ // 添加
            if(self::Db()->where('name',$data['name'])->where('pid',$data['pid'])->count()) throw new \Exception('名称已存在');

            if($id = self::Db()->insertGetId($update)) return self::Success('添加成功',$id);
            else return self::Error('添加失败');
        }
    }
}