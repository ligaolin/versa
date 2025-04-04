<?php

namespace app\api\controller;

use app\BaseController;
use think\facade\Db;
use app\api\param\Base as BaseApi;
use app\utils\Other;

class Base extends BaseController
{
    static $table = '';
    static $changeField = ['sort','state'];

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

    static function Success($msg,$data=null){
        return self::Res($msg,$data,2000);
    }

    static function Error($msg,$data=null){
        return self::Res($msg,$data,1000);
    }

    static function Db($table=''){
        return Db::name($table?$table:static::$table);
    }

    function Change($where=[]){
        if(!static::$table) throw new \Exception('数据表未定义');
        $param = input();
        BaseApi::Validate([
            ['whereField',null,['require','条件字段必须']],
            ['whereVal',null,['require','条件值必须必须']],
            ['changeField',null,['require','修改字段必须']],
            ['changeVal',null,['require','修改字段值必须']],
        ],$param);
        if(!in_array($param['changeField'],static::$changeField)) throw new \Exception('非法字段');
        $db = self::Db();
        if($where) $db = $db->where($where);
        $db->where($param['whereField'],$param['whereVal'])->update([
            $param['changeField']=>$param['changeVal'],
        ]);
        return self::success('修改完成');
    }

    // 删除
    function Del(){
        if(!static::$table) throw new \Exception('数据表未定义');
        $param = input();
        if(!isset($param['id']) || !$param['id']) throw new \Exception('id必须');
        $idArr = self::DataToAarray($param['id']);
        $arr = [];
        foreach($idArr as $id){
            $find = self::Db()->where('id',$id)->find();
            $arr[] = $id;
            if(isset($find['pid'])) $arr = array_merge($arr,self::getChildrenId($id));
        }
        if(self::Db()->delete($arr)){
            return self::success("删除完成");
        }else{
            throw new \Exception('删除出错');
        }
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

    protected static function getChildrenId($id,$pid='pid'){
        $idArr = self::DataToAarray($id);
        $idArr1 = self::Db()->where($pid,'in',$idArr)->column('id');
        $arr = [];
        if(count($idArr1)){
            foreach($idArr1 as $val){
                $arr[] = $val;
                $arr = array_merge($arr,self::getChildrenId($val,$pid));
            }
        }
        return $arr;
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

        $pageNum = 10;
        if(isset($data['pageNum']) && $data['pageNum']) $pageNum = $data['pageNum'];
        if(isset($data['page_num']) && $data['page_num']) $pageNum = $data['page_num'];

        if(isset($data['page']) && $data['page']){
            $res = $db->paginate([
                'list_rows'=> $pageNum,
                'page' => $data['page'],
            ])->toArray();
            $res['total_page'] = intval($res['total']/$pageNum);
            if($res['total']%$pageNum) $res['total_page']++;
        }else{
            $res['data'] = $db->select()->toArray();
        }
        
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