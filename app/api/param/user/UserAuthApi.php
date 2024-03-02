<?php

namespace app\api\param\user;

use app\api\param\Base;

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
        ['type',null],

        ['state','开启'],
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $GetListByPid = [
        ['pid',0,['require','上级ID必须']],

        ['name',null],
        ['type',null],
        ['route',null],
        ['state','开启'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['pid',0],
        ['level',1],
        ['name',null,['require','名称必须']],
        ['route',null],
    ];
}