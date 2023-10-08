<?php

namespace app\controller\db;

use app\controller\Base;
use app\api\db\TableApi;
use think\facade\Db;

class Table extends Base
{
    static $table = 'table';
    static $changeField = ['name','sort','state'];

    function Edit(){
        $update = $data = TableApi::Get(TableApi::$Edit);
        unset($update['id']);

        if($data['id']){
            // 表是否已存在
            if(self::Db()->where('id != '.$data['id'].' AND `name` = "'.$data['name'].'"')->count()) throw new \Exception('数据表已存在');

            // 数据表是否需要执行修改语句
            $find = self::Db()->where('id = '.$data['id'])->find();
            if($find['name']!=$data['name']) Db::query("alter table `{$find['name']}` rename {$data['name']}");
            if($find['cname']!=$data['cname']) Db::query("alter table `{$data['name']}` comment '{$data['cname']}'");

            self::Db()->where('id = '.$data['id'])->update($update);
            return self::Success('更新成功');
        }else{
            // 表是否已存在
            if(self::Db()->where('`name` = "'.$data['name'].'"')->count()) throw new \Exception('数据表已存在');
            Db::query("
                CREATE TABLE IF NOT EXISTS `{$data['name']}` (
                    `id` bigint NOT NULL AUTO_INCREMENT,
                    `sort` int NOT NULL DEFAULT '100' COMMENT '排序',
                    `state` enum('开启','关闭') COLLATE utf8mb4_general_ci NOT NULL DEFAULT '开启' COMMENT '状态',
                    `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '创建时间',
                    `updated_at` timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP COMMENT '更新时间',
                    PRIMARY KEY (`id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='{$data['cname']}'
            ");
            $id = self::Db()->insertGetId($update);
            return self::Success('添加成功',$id);
        }
    }
}