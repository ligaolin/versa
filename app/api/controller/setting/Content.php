<?php

namespace app\api\controller\setting;

use app\api\controller\Base;
use app\api\api\setting\ContentApi;
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
             if($res['data']['search']) $res['data']['search'] = json_decode($res['data']['search']);
             if($res['data']['list']) $res['data']['list'] = json_decode($res['data']['list']);
             if($res['data']['default_field']) $res['data']['default_field'] = json_decode($res['data']['default_field']);
        }
        return self::Success('获取完成',$res);
    }
    
    function List(){
        $data = ContentApi::Get(ContentApi::$List);
        $where = self::Where($data,[
            ['name'=>'content.id','type'=>'in'],
            ['name'=>'content.name','type'=>'like'],
            ['name'=>'content.cname','type'=>'like'],
            ['name'=>'content.cate_id','type'=>'like'],
            ['name'=>'content.state','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where)->leftJoin('admin_cate','admin_cate.id = content.cate_id')->field('content.*,admin_cate.name as cate_name'),$data);
        foreach ($res['data'] as $k => $v) {
            $res['data'][$k]['field'] = self::Db('content_field')->where('content_id',$v['id'])->select();
            if($v['search']) $res['data'][$k]['search'] = json_decode($v['search']);
            if($v['list']) $res['data'][$k]['list'] = json_decode($v['list']);
            if($v['default_field']) $res['data'][$k]['default_field'] = json_decode($v['default_field']);
        }
        return self::Success('获取完成',$res);
    }

    function Edit(){
        Db::startTrans();
        try{
            $update = $data = ContentApi::Get(ContentApi::$Edit);
            unset($update['id']);
            if($update['search']) $update['search'] = json_encode($update['search']);
            if($update['list']) $update['list'] = json_encode($update['list']);
            if($update['default_field']) $update['default_field'] = json_encode($update['default_field']);

            if($data['id']){ // 更新
                $find = self::Db()->where('id',$data['id'])->find();
                if($find['name'] != $data['name'])  {
                    if(Table::TableIfExists($data['name'])) throw new \Exception('英文名称不可用');
                    // 修改表名称
                    Table::EditTable($find['name'],$data['name'],$data['cname']);
                }
                // 默认字段
                self::setDefaultField($data['default_field'],$data['name']);
                // 栏目
                self::setCate($data['cate_id'],$data['cate_pid'],$data['cname'],$data['id']);

                self::Db()->where('id = '.$data['id'])->update($update);
                Db::commit();
                return self::Success('更新完成');
            }else{ // 添加
                if($id = self::Db()->insertGetId($update)) {
                    if(Table::TableIfExists($data['name'])) throw new \Exception('英文名称不可用');
                    Table::AddTable($data['name'],$data['cname']);
                    // 默认字段
                    self::setDefaultField($data['default_field'],$data['name']);
                    // 栏目
                    self::setCate($data['cate_id'],$data['cate_pid'],$data['cname'],$id);

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

    // 设置默认字段
    static function setDefaultField($default_field,$table){
        // 默认字段
        self::setField(in_array('多级数据，包含字段：pid（上级ID）、level(第几级)',$default_field)?'add':'del',$table,'pid','int',false,0,'上级ID');
        self::setField(in_array('多级数据，包含字段：pid（上级ID）、level(第几级)',$default_field)?'add':'del',$table,'level','int',false,1,'层级');
        self::setField(in_array('排序，包含字段：sort',$default_field)?'add':'del',$table,'sort','int',false,100,'排序');
        self::setField(in_array('状态，包含字段：state',$default_field)?'add':'del',$table,'state',"enum('开启','关闭')",false,'开启','状态');
        self::setField(in_array('更新时间，包含字段：created_at（添加）、updated_at（更新）',$default_field)?'add':'del',$table,'created_at',"timestamp",false,'CURRENT_TIMESTAMP','添加时间');
        self::setField(in_array('更新时间，包含字段：created_at（添加）、updated_at（更新）',$default_field)?'add':'del',$table,'updated_at',"timestamp",false,'CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP','更新时间');
    }

    // 设置字段
    static function setField($oper,$table,$name,$type,$isNull=null,$default=null,$comment=null){
        if($oper=='add'){ // 添加
            // 查看是否存在
            if(!Table::FieldIfExists($table,$name)) Table::AddField($table,$name,$type,$isNull,$default,$comment);
        }else{ // 删除
            if(Table::FieldIfExists($table,$name)) Table::DelField($table,$name);
        }
    }

    // 设置栏目
    static function setCate($cate_id,$cate_pid,$name,$id){
        $level = self::Db('admin_cate')->where('id',$cate_pid)->value('level');
        $level++;
        if($cate_id){
            self::Db('admin_cate')->where('id',$cate_id)->update([
                'pid'=>$cate_pid,
                'level'=>$level,
                'name'=>$name,
                'path'=>'content?id='.$id.'&name='.$name,
                'view'=>'../views/setting/content/content.vue',
            ]);
        }else{
            $cate_id = self::Db('admin_cate')->insertGetId([
                'pid'=>$cate_pid,
                'level'=>$level,
                'name'=>$name,
                'type'=>'页面',
                'path'=>'content?id='.$id.'&name='.$name,
                'view'=>'../views/setting/content/content.vue',
            ]);
        }
        self::Db()->where('id',$id)->update(['cate_id'=>$cate_id]);
    }

    function Change($where=[]){
        $data = ContentApi::Get(ContentApi::$Chage);
        if($data['changeField']=='state'){
            if($cate_id = self::Db()->where($data['whereField'],$data['whereVal'])->value('cate_id')) self::Db('admin_cate')->where('id',$cate_id)->update(['state'=>$data['changeVal']]);
        }
        return parent::Change();
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
            return self::success("删除完成");
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}
