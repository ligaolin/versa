<?php

namespace app\controller;

use app\BaseController;

class Base extends BaseController
{
    static function ResData($data){
        return json($data);
    }

    static function Res($msg,$data,$code){
        $res = ['code'=>$code,'msg'=>$msg];
        if(is_object($data)) $data = json_decode(json_encode($data),true);
        if(is_array($data)) $res = array_merge($data,$res);
        else $res['data'] = $data;
        return json($res);
    }

    static function Success($msg,$data=[]){
        return self::Res($msg,$data,2000);
    }

    static function Error($msg,$data=[]){
        return self::Res($msg,$data,1000);
    }

    /**
     * @description: 获取mysql查询条件
     * @param {*} $param
     * @param {*} $whereData 示例数据[['name'=>'name','nullable'=>false,'type'=>'in','key'=>'store_name']]
     * @return {*}
     */
    static function Where($param,$whereData){
        $where = ' 1';
        foreach($whereData as $val){
            if(!isset($val['name']) || !$val['name']) continue;
            if(!isset($val['type']) || !$val['type']) continue;
            if(!isset($val['nullable'])) $val['nullable'] = false;
            $karr = explode('.',$val['name']);
            $k = end($karr);
            if(!isset($param[$k])) continue;
            $data = $param[$k];
            if(!$val['nullable'] && $data==='') continue;
            
            $key = isset($val['key'])&&$val['key']?$val['key']:$val['name'];
            if(count(explode('.',$key))==1) $key = "`{$key}`";
            switch ($val['type']) {
                case 'in':
                    $res = self::DataToAarray($data);
                    if(count($res) == 1){
                        $where .= " AND {$key} = '{$data}'";
                    }else{
                        $v = implode("','",$res);
                        $where .= " AND {$key} in ('{$v}')";
                    }
                    break;
                case 'like':
                    $where .= " AND {$key} like '%{$data}%'";
                    break;
                case '!=':
                    $where .= " AND {$key} != '{$data}'";
                    break;
                case 'notNull':
                    $where .= " AND {$key} is not null";
                    break;
                case 'null':
                    $where .= " AND {$key} is null";
                    break;
                case '>':
                    $where .= " AND {$key} > '{$data}'";
                    break;
                case '>=':
                    $where .= " AND {$key} >= '{$data}'";
                    break;
                case '<':
                    $where .= " AND {$key} < '{$data}'";
                    break;
                case '<=':
                    $where .= " AND {$key} <= '{$data}'";
                    break;
            }
        }
        return $where;
    }

    /**
     * @description: 数据转数组
     * @param {*} $data
     * @return {*}
     */    
    static function DataToAarray($data){
        if(is_object($data)) return json_decode(json_encode($data), true);
        if(is_array($data)) return $data;
        return explode(',',$data);
    }
}