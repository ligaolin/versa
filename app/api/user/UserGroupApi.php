<?php

namespace app\api\user;

use app\api\Base;

class UserGroupApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
    ];

    static $List = [
        ['id',null],
        ['name',null],
        ['auth_ids',null],
        ['state','开启'],
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null],
        ['name',null,['require','名称必须']],
        ['auth_ids',null],
        ['sort',100],
        ['state','开启'],
    ];
}