<?php

namespace app\controller\setting;

use app\controller\Base;
use app\api\setting\ConfigTypeApi;
use think\facade\Db;

class ConfigType extends Base
{
    static $table = 'config_type';
    static $changeField = ['label','type'];

    function List(){
        $data = ConfigTypeApi::Get(ConfigTypeApi::$List);
        $where = self::Where($data,[
            ['name'=>'id','type'=>'in'],
            ['name'=>'name','type'=>'like'],
            ['name'=>'type','type'=>'in'],
        ]);
        $res = self::GetList(self::Db()->where($where),$data);
        return self::Success('获取完成',$res);
    }

    function Edit(){
        Db::startTrans();
        try{
            $update = $data = ConfigTypeApi::Get(ConfigTypeApi::$Edit);
            unset($update['id']);
            if($data['id']){ // 更新
                if(self::Db()->where('name',$data['name'])->where('id','<>',$data['id'])->count()) throw new \Exception('已有相同名称');
                if(self::Db()->where('type',$data['type'])->where('id','<>',$data['id'])->count()) throw new \Exception('已有相同类型值');

                $find = self::Db()->where('id',$data['id'])->find();
                if($find['type'] != $update['type']) self::Db('config')->where('type',$find['type'])->update(['type'=>$update['type']]);
                
                self::Db()->where('id = '.$data['id'])->update($update);
                Db::commit();
                return self::Success('更新完成');
            }else{ // 添加
                if(self::Db()->where('name',$data['name'])->count()) throw new \Exception('已有相同名称');
                if(self::Db()->where('type',$data['type'])->count()) throw new \Exception('已有相同类型值');
                
                if($id = self::Db()->insertGetId($update)) {
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

    function Del(){
        Db::startTrans();
        try{
            $data = ConfigTypeApi::Get(ConfigTypeApi::$Del);
            $types = self::Db()->where('id','in',$data['id'])->column('type');
            self::Db('config')->where('type','in',$types)->delete();
            Db::commit();
            return parent::Del();
        } catch (\Exception $e) {
            // 回滚事务
            Db::rollback();
            throw new \Exception($e->getMessage());
        }
    }
}
