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
        ['id',null,['number','id必须数字']],
        ['name',null,['require','名称必须']],
        ['auth_ids',null],
        ['sort',100,['number','排序必须数字']],
        ['state','开启',['in:开启,关闭','状态值错误']],
    ];
}