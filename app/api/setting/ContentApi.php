<?php

namespace app\api\setting;

use app\api\Base;

class ContentApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
        ['cname',null],
    ];

    static $List = [
        ['id',null],
        ['name',null],
        ['cname',null],
        ['cate_id',null],
        ['state',null],
        
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','英文名称必须']],
        ['cname',null,['require','中文名称必须']],
        ['cate_pid',null,['require','所属栏目必须']],
        ['cate_id',null],
        ['default_field',null],
        ['search',null],
        ['list',null],
    ];

    static $Chage = [
        ['changeField',null,['require','修改字段必须']],
        ['changeVal',null,['require','修改值必须']],
        ['whereField',null,['require','条件必须']],
        ['whereVal',null,['require','条件值必须']],
    ];

    static $Del = [
        ['id',null,['require','id名称必须']],
    ];
}