<?php

namespace app\controller\setting;

use app\controller\Base;
use app\api\setting\ContentApi;
use think\facade\Db;
use app\utils\Table as Table;

class Content extends Base
{
    static $table = 'content';
    static $changeField = ['sort','state'];

    function Get(){
        $data = ContentApi::Get(ContentApi::$Get);
        $where = self::Where($data,[
            ['name'=>'content.id','type'=>'in'],
            ['name'=>'content.name','type'=>'in'],
            ['name'=>'content.cname','type'=>'in'],
        ]);
        if($res['data'] = self::Db()->where($where)->leftJoin('admin_cate','admin_cate.id = content.cate_id')->field('content.*,admin_cate.name as cate_name')->find()) {
             $res['data']['field'] = self::Db('content_field')->where('content_id',$res['data']['id'])->select();
        }
        return self::Success('获取完成',$res);
    }
    
    function List(){
        $data = ContentApi::Get(ContentApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'cname','type'=>'like'],
        ]);
        $res = self::GetList(self::Db()->where($where)->leftJoin('admin_cate','admin_cate.id = content.cate_id')->field('content.*,admin_cate.name as cate_name'),$data);
        foreach ($res['data'] as $k => $v) {
            $res['data'][$k]['field'] = self::Db('content_field')->where('content_id',$v['id'])->select();
        }
        return self::Success('获取完成',$res);
    }

    function Edit(){
        Db::startTrans();
        try{
            $update = $data = ContentApi::Get(ContentApi::$Edit);
            unset($update['id']);
            unset($update['icon']);

            if($data['id']){ // 更新
                $find = self::Db()->where('id',$data['id'])->find();
                if($find['name'] != $data['name'])  {
                    if(Table::TableIfExists($data['name'])) throw new \Exception('英文名称不可用');
                    // 修改表名称
                    Table::EditTable($find['name'],$data['name'],$data['cname']);
                }
                
                self::Db()->where('id = '.$data['id'])->update($update);

                self::setCate($data['cate_id'],$data['cate_pid'],$data['icon'],$data['name'],$data['id']);

                Db::commit();
                return self::Success('更新完成');
            }else{ // 添加
                if(Table::TableIfExists($data['name'])) throw new \Exception('英文名称不可用');
                Table::AddTable($data['name'],$data['cname']);
                
                if($id = self::Db()->insertGetId($update)) {
                    self::setCate($data['cate_id'],$data['cate_pid'],$data['icon'],$data['name'],$id);

                    Db::commit();
                    return self::Success('添加成功',$id);
                } else return self::Error('添加失败');
            }
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    static function setCate($cate_id,$cate_pid,$icon,$name,$id){
        $level = self::Db('admin_cate')->where('id',$cate_pid)->value('level');
        $level++;
        if($cate_id){
            self::Db('admin_cate')->where('id',$cate_id)->update([
                'icon'=>$icon,
                'pid'=>$cate_pid,
                'level'=>$level,
            ]);
        }else{
            $cate_id = self::Db('admin_cate')->insertGetId([
                'icon'=>$icon,
                'pid'=>$cate_pid,
                'level'=>$level,
                'name'=>$name,
                'type'=>'页面',
                'path'=>'content/'.$name.'/index',
                'view'=>'../views/content/index.vue',
            ]);
        }
        self::Db()->where('id',$id)->update(['cate_id'=>$cate_id]);
    }

    function Del(){
        Db::startTrans();
        try{
            $data = ContentApi::Get(ContentApi::$Del);

            $data['id'] = self::DataToAarray($data['id']);
            $list = self::Db()->where('id','in',$data['id'])->select();
            foreach($list as $v) {
                Table::DelTable($v['name']);
                self::Db('admin_cate')->where('id',$v['cate_id'])->delete();
            }
            self::Db()->where('id','in',$data['id'])->delete();
            Db::commit();
            return parent::Del();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}
