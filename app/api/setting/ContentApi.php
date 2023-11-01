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

        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','英文名称必须']],
        ['cname',null],
        ['cate_pid',null,['require','所属栏目必须']],
        ['cate_id',null],
        ['icon',null],
    ];

    static $Del = [
        ['id',null,['require','id名称必须']],
    ];
}