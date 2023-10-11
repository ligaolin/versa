<?php

namespace app\utils;

use think\facade\Db;

class Table{
    // 构建分页查询语句
    static function Page($page=1,$pageNum=10){
        $offset = ($page - 1) * $pageNum+1; // 偏移量
        return " LIMIT {$offset},{$pageNum}";
    }

    // 查询所有数据表
    static function TableList(){
        $list = Db::query("SHOW TABLES");
        $arr = [];
        if($list && count($list)){
            foreach($list as $val){
                foreach($val as $val1){
                    $arr[] = $val1;
                }
            }
        }
        return $arr;
    }

    // 判断数据表是否存在
    static function TableIfExists($name){
        $res = Db::query("SHOW TABLES LIKE '{$name}'");
        if($res) return true;
        return false;
    }

    // 通过表注释查询表
    static function CommGetTable($comm){
        $res = Db::query("
            SELECT TABLE_NAME
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = '".env('DB_NAME')."' AND TABLE_COMMENT LIKE '%{$comm}%';
        ");
        $arr = [];
        if($res && count($res)){
            foreach($res as $val){
                foreach($val as $val1){
                    $arr[] = $val1;
                }
            }
        }
        return $arr;
    }

    // 查询表注释
    static function TableComm($name){
        $res = Db::query("
            SELECT TABLE_NAME, TABLE_COMMENT
            FROM information_schema.TABLES
            WHERE TABLE_SCHEMA = '".env('DB_NAME')."'
            AND TABLE_NAME = '{$name}';
        ");
        if($res) return $res[0]['TABLE_COMMENT'];
        return '';
    }

    // 编辑表信息
    static function EditTable($oldname,$name,$comment){
        if(!self::TableIfExists($oldname)) throw new \Exception('数据表不存在');
        if($oldname!=$name) Db::query("ALTER TABLE `{$oldname}` rename {$name}");
        Db::query("ALTER TABLE `{$name}` comment '{$comment}'");
    }

    // 添加表
    static function AddTable($name,$comment){
        Db::query("
            CREATE TABLE IF NOT EXISTS `{$name}` (
                `id` bigint NOT NULL AUTO_INCREMENT COMMENT 'ID',
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='{$comment}'
        ");
    }

    // 删除表
    static function DelTable($name){
        Db::query("DROP TABLE IF EXISTS `{$name}`");
    }

    // 查询表字段
    static function FiledList($name){
        if(!self::TableIfExists($name)) return [];
        return Db::query("SHOW COLUMNS FROM `{$name}`");
    }

    // 添加字段
    static function AddField($table,$name,$type,$isNull=null,$default=null,$Key=null){
        $sql = "ALTER TABLE {$table} ADD {$name} {$type}";
        if(!$isNull) $sql .= " NOT NULL";
        if(!$default) $sql .= " DEFAULT {$default}";
        if($Key) $sql .= " ADD KEY {$Key} ({$name})";
        return Db::query($sql);
    }

    // 修改字段
    static function AlterField($table,$name,$type,$isNull=null,$default=null,$Key=null){
        $sql = "ALTER TABLE {$table} MODIFY {$name} {$type}";
        if(!$isNull) $sql .= " NOT NULL";
        if(!$default) $sql .= " DEFAULT {$default}";
        if($Key) $sql .= " ADD KEY {$Key} ({$name})";
        return Db::query($sql);
    }
}