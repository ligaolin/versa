<?php

namespace app\utils;

use think\facade\Db;

class Table{
    // 构建分页查询语句
    static function Page($page=1,$pageNum=10){
        $offset = ($page - 1) * $pageNum+1; // 偏移量
        return " LIMIT {$offset},{$pageNum}";
    }

    // 数据库备份
    static function Backups(){
        $backupFile = './public/db/' . date('Y-m-d-H-i-s') . '.sql';
        $sql = 'mysqldump';
        $DB_USER = env('DB_USER');
        $DB_PASS = env('DB_PASS');
        $DB_HOST = env('DB_HOST');
        $DB_NAME = env('DB_NAME');
        $DB_PORT = env('DB_PORT');
        if($DB_HOST) $sql .= ' -h'.$DB_HOST;
        if($DB_PORT) $sql .= ' -P'.$DB_PORT;
        if($DB_USER) $sql .= ' -u'.$DB_USER;
        if($DB_PASS) $sql .= ' -p'.$DB_PASS;
        if($DB_NAME) $sql .= ' '.$DB_NAME;
        $sql .= ' > '.$backupFile;
        // Db::execute($sql);
        exec($sql);
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
        if($oldname){
            if(!self::TableIfExists($oldname)) throw new \Exception('数据表不存在');
            if($oldname!=$name) Db::query("ALTER TABLE `{$oldname}` rename `{$name}`");
        }
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

    // 查询字段注释
    static function FieldComm($table){
        return Db::query("SELECT COLUMN_NAME, COLUMN_COMMENT
        FROM INFORMATION_SCHEMA.COLUMNS
        WHERE TABLE_SCHEMA = '".env('DB_NAME')."' AND TABLE_NAME = '{$table}'");
    }

    // 查询表字段
    static function FieldList($name){
        if(!self::TableIfExists($name)) return [];
        $fields = Db::query("SHOW COLUMNS FROM `{$name}`");
        $comms = Db::query("SELECT COLUMN_NAME, COLUMN_COMMENT FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA = '".env('DB_NAME')."' AND TABLE_NAME = '{$name}'");
        foreach ($fields as $k => $v) {
            foreach ($comms as $k1 => $v1) {
                if($v1['COLUMN_NAME'] == $v['Field']) $fields[$k]['comment'] = $v1['COLUMN_COMMENT'];
            }
        }
        return $fields;
    }

    // 添加字段
    static function AddField($table,$name,$type,$isNull=null,$default=null,$comment=null,$key=null){
        $sql = "ALTER TABLE `{$table}` ADD `{$name}` {$type}";
        if(!$isNull) $sql .= " NOT NULL";
        if($default!=='') $sql .= " DEFAULT '{$default}'";
        if($comment) $sql .= " COMMENT '{$comment}'";
        if($key) $sql .= " ADD KEY {$key} ({$name})";
        return Db::query($sql);
    }

    // 修改字段
    static function AlterField($table,$oldName,$name,$type,$isNull=null,$default=null,$comment=null,$key=null){
        if($name==$oldName) $sql = "ALTER TABLE `{$table}` MODIFY `{$name}`";
        else  $sql = "ALTER TABLE `{$table}` CHANGE `{$oldName}` `{$name}`";
        $sql .= " {$type}";
        if(!$isNull) $sql .= " NOT NULL";
        else $sql .= " NULL";
        if($default!=='') $sql .= " DEFAULT '{$default}'";
        if($comment) $sql .= " COMMENT '{$comment}'";
        if($key) $sql .= " ADD KEY {$key} ({$name})";
        return Db::query($sql);
    }

     // 判断字段是否存在
     static function FieldIfExists($table,$name){
        foreach (self::FieldList($table) as $val) {
            if($val['Field'] == $name) return true;
        }
        return false;
    }

    // 删除字段
    static function DelField($table,$name){
        return Db::query("ALTER TABLE `{$table}` DROP `{$name}`");
    }
}