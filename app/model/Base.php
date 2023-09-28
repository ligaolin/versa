<?php
namespace app\model;

use think\Model;

class Base extends Model
{
    static function list($db,$data,$order=''){
        if(isset($data['order']) && $data['order'] && is_string($data['order'])) $db = $db->orderRaw($data['order']);
        else if($order)  $db = $db->orderRaw($order);
        if(isset($data['page']) && $data['page']){
            return $db->paginate([
                'list_rows'=> isset($data['pageNum']) && $data['pageNum']?$data['pageNum']:10,
                'page' => $data['page'],
            ]);
        }else{
            return ['data'=>$db->select()];
        }
    }
}