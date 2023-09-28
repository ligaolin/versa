<?php

namespace app\api\user;

use app\api\Base;

class UserAuthApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
        ['route',null],
    ];

    static $List = [
        ['id',null],
        ['pid',null],
        ['level',null],
        ['name',null],
        ['route',null],
        ['state','开启'],
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null],
        ['pid',0],
        ['level',1],
        ['name',null,['require','名称必须']],
        ['route',null],
        ['sort',100],
        ['state','开启'],
    ];
}