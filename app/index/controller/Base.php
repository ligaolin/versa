<?php

namespace app\index\controller;

use app\BaseController;
use think\facade\Db;
use app\utils\Other;

class Base extends BaseController
{
    static $table = '';
    static $changeField = ['sort','state'];

    static function Db($table=''){
        return Db::name($table?$table:static::$table);
    }
 
    static protected function AllChildren($pid,$where=' 1',$order=''){
        $db = self::Db();
        if($where) $db = $db->where($where." AND `pid` = {$pid}");
        else $db = $db->where("`pid` = {$pid}");
        if($order && is_string($order)) $db = $db->orderRaw($order);
        $list = $db->select()->toArray();
        if($list && count($list)){
            foreach ($list as $key => $val) {
                $list[$key]['children'] = self::AllChildren($val['id'],$where,$order);
            }
        }
        return $list;
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
                        $where .= " AND {$key} = '{$res[0]}'";
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
                case 'set':
                    $where .= " AND FIND_IN_SET('{$data}',{$key})";
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

    static function GetList($db,$data,$order='',$pid='',$childwhere=''){
        if(isset($data['order']) && $data['order'] && is_string($data['order'])) $db = $db->orderRaw($data['order']);
        else if($order)  $db = $db->orderRaw($order);
        if(isset($data['page']) && $data['page']){
            $res = $db->paginate([
                'list_rows'=> isset($data['pageNum']) && $data['pageNum']?$data['pageNum']:10,
                'page' => $data['page'],
            ]);
        }else{
            $res = ['data'=>$db->select()];
        }
        $res = json_decode(json_encode($res),true);
        if($pid){
            foreach ($res['data'] as $k => $v) {
                $cdb = self::Db()->where($pid,$v['id']);
                if($childwhere) $cdb = $cdb->where($childwhere);
                if($cdb->count()) $res['data'][$k]['hasChildren'] = true;
                else $res['data'][$k]['hasChildren'] = false;
            }
        }
        return $res;
    }

    static function MakeCode($field,$len=7,$table=''){
        $code = Other::randomStr($len);
        if(self::Db($table)->where($field,$code)->count()){
            self::makeCode($field,$table);
        }else{
            return $code;
        }
    }
}