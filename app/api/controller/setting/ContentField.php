<?php

namespace app\api\controller\setting;

use app\api\controller\Base;
use app\api\api\setting\ContentFieldApi;
use think\facade\Db;
use app\utils\Table as Table;

class ContentField extends Base
{
    static $table = 'content_field';
    static $changeField = ['sort','state'];

    function Get(){
        $data = ContentFieldApi::Get(ContentFieldApi::$Get);
        $where = self::Where($data,[
            ['content_field.name'=>'id','type'=>'in'],
            ['content_field.name'=>'name','type'=>'in'],
            ['content_field.name'=>'cname','type'=>'in'],
        ]);
        $res['data'] = self::Db()->where($where)
            ->leftJoin('content','content.id = content_field.content_id')->field('content_field.*,content.name as content_name')
            ->find();
        return self::Success('获取完成',$res);
    }
    
    function List(){
        $data = ContentFieldApi::Get(ContentFieldApi::$List);
        $where = self::Where($data,[
            ['name'=>'content_field.id','type'=>'in'],
            ['name'=>'content_field.content_id','type'=>'in'],
            ['name'=>'content_name','type'=>'like','key'=>'content.name'],
            ['name'=>'content_field.name','type'=>'like'],
            ['name'=>'content_field.cname','type'=>'like'],
            ['name'=>'content_field.type','type'=>'in'],
            ['name'=>'content_field.is_null','type'=>'in'],
            ['name'=>'content_field.is_repeat','type'=>'in'],
            ['name'=>'content_field.default','type'=>'like'],
            ['name'=>'content_field.table','type'=>'like'],
            ['name'=>'content_field.field','type'=>'like'],
            ['name'=>'content_field.state','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where)
            ->leftJoin('content','content.id = content_field.content_id')->field('content_field.*,content.name as content_name')
        ,$data);
        return self::Success('获取完成',$res);
    }

    function Edit(){
        Db::startTrans();
        try{
            $update = $data = ContentFieldApi::Get(ContentFieldApi::$Edit);
            unset($update['id']);
            if(in_array($data['type'],['单选项','多选项','下拉菜单']) && !$data['vals']) throw new \Exception('该类型可选值必须');
            if(in_array($data['type'],['关联数据单选器','关联数据多选器']) && !$data['table']) throw new \Exception('该类型关联表名称必须');
            if(in_array($data['type'],['关联数据单选器','关联数据多选器']) && !$data['field']) throw new \Exception('该类型关联表的关联字段必须');
            if(in_array($data['type'],['关联数据单选器','关联数据多选器']) && !$data['field_name']) throw new \Exception('该类型关联表的显示字段必须');
            
            if($data['id']){ // 更新
                if(self::Db()->where('name',$data['name'])->where('content_id',$data['content_id'])->where('id','<>',$data['id'])->count()) throw new \Exception('已有相同名称');
                
                // 修改字段
                $table = self::Db('content')->where('id',$data['content_id'])->value('name');
                $oldName = self::Db()->where('id',$data['id'])->value('name');
                if(!Table::TableIfExists($table)) throw new \Exception('内容表不存在');
                if(!Table::FieldIfExists($table,$oldName)) throw new \Exception('内容表字段不存在');
                $type = self::setFieldType($data['type'],$data['vals'],$data['default']);
                Table::AlterField($table,$oldName,$data['name'],$type,$data['is_null']=='可以'?true:false,$data['default'],$data['cname']);

                self::Db()->where('id = '.$data['id'])->update($update);
                Db::commit();
                return self::Success('更新完成');
            }else{ // 添加
                if(self::Db()->where('name',$data['name'])->where('content_id',$data['content_id'])->count()) throw new \Exception('已有相同名称');

                // 添加字段
                $table = self::Db('content')->where('id',$data['content_id'])->value('name');
                if(!Table::TableIfExists($table)) throw new \Exception('数据表不存在');
                if(Table::FieldIfExists($table,$data['name'])) throw new \Exception('表字段已存在');
                $type = self::setFieldType($data['type'],$data['vals'],$data['default']);
                Table::AddField($table,$data['name'],$type,$data['is_null']=='可以'?true:false,$data['default'],$data['cname']);

                if($id = self::Db()->insertGetId($update)) {
                    Db::commit();
                    return self::Success('添加成功',$id);
                } else return self::Error('添加失败');
            }
        } catch (\Exception $e) {
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
    }

    static function setFieldType($type,$vals,$default=''){
        if($vals) $vals = explode(',',$vals);
        else $vals = [];
        // '单行文本','单行整数','单行小数','多行文本','单选项','多选项','下拉菜单','上传图片','上传视频','上传文件','时间','日期','时间和日期','编辑器','关联数据单选器','关联数据多选器'
        switch ($type) {
            case '单行文本':
                return 'varchar(255)';
            case '单行数字':
                return 'int';
            case '单行数字':
                return 'float';
            case '多行文本':
                return 'text';
            case '单选项':
                if($default && !in_array($default,$vals)) throw new \Exception('默认值错误');
                return "enum('".implode("','",$vals)."')";
            case '多选项':
                if($default){
                    foreach (explode(',',$default) as $v) {
                        if(!in_array($v,$vals)) throw new \Exception('默认值错误');
                    }
                }
                return "set('".implode("','",$vals)."')";
            case '下拉菜单':
                if($default && !in_array($default,$vals)) throw new \Exception('默认值错误');
                return "enum('".implode("','",$vals)."')";
            case '上传图片':
                return 'text';
            case '上传视频':
                return 'text';
            case '上传文件':
                return 'text';
            case '时间':
                return 'time';
            case '日期':
                return 'date';
            case '时间和日期':
                return 'datetime';
            case '编辑器':
                return 'longtext';
            case '关联数据单选器':
                return 'varchar(50)';
            case '关联数据多选器':
                return 'varchar(255)';
            default:
                return 'varchar(255)';
        }
    
    }

    function Del(){
        Db::startTrans();
        try{
            $data = ContentFieldApi::Get(ContentFieldApi::$Del);

            $data['id'] = self::DataToAarray($data['id']);
            $list = self::Db()->where('id','in',$data['id'])->select();
            foreach($list as $v) {
                $table = self::Db('content')->where('id',$v['content_id'])->value('name');
                Table::DelField($table,$v['name']);
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
