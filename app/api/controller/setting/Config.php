<?php

namespace app\api\controller\setting;

use app\api\controller\Base;
use app\api\param\setting\ConfigApi;
use think\facade\Cache;

class Config extends Base
{
    static $table = 'config';
    static $changeField = ['sort','val'];

    function Get(){
        $data = ConfigApi::Get(ConfigApi::$Get);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'in'],
        ]);
        $res['data'] = self::Db()->where($where)->find();
        if($res['data']['field_type']=='上传图片' || $res['data']['field_type']=='上传视频' || $res['data']['field_type']=='上传文件') $res['data']['val'] = json_decode($res['data']['val']);
        return self::Success('获取完成',$res);
    }

    function List(){
        $data = ConfigApi::Get(ConfigApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'type','type'=>'in'],
            ['name'=>'field_type','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where),$data);
        foreach($res['data'] as $k => $v) {
            if($v['field_type']=='上传图片' || $v['field_type']=='上传视频' || $v['field_type']=='上传文件') $res['data'][$k]['val'] = json_decode($v['val']);
        }
        return self::Success('获取完成',$res);
    }

    function Edit(){
        $update = $data = ConfigApi::Get(ConfigApi::$Edit);
        unset($update['id']);
        if($data['field_type']=='上传图片' || $data['field_type']=='上传视频' || $data['field_type']=='上传文件') {
            if(!$update['val']) $update['val'] = [];
            $update['val'] = json_encode($update['val']);
        }
        
        if($data['id']){ // 更新
            if(self::Db()->where('name',$data['name'])->where('id','<>',$data['id'])->count()) throw new \Exception('已有相同名称');
            
            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新完成');
        }else{ // 添加
            if(self::Db()->where('name',$data['name'])->count()) throw new \Exception('已有相同名称');
            
            if($id = self::Db()->insertGetId($update)) return self::Success('添加成功',$id);
            else return self::Error('添加失败');
        }
    }

    function ForEditVal(){
        $data = input('data');
        foreach ($data as $k => $v) {
            if($v['field_type']=='上传图片' || $v['field_type']=='上传视频' || $v['field_type']=='上传文件') {
                if(!$v['val']) $v['val'] = [];
                $v['val'] = json_encode($v['val']);
            }
            self::Db()->where('id = '.$v['id'])->update(['val'=>$v['val']]);
        }
        return self::Success('更新完成');
    }

    function CacheClear(){
        Cache::clear();
        return self::Success('清理缓存完成');
    }
}
