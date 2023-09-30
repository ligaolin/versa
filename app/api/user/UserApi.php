<?php

namespace app\api\user;

use app\api\Base;

class UserApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
    ];

    static $List = [
        ['id',null],
        ['name',null],
        ['user_group_id',null],
        ['type',null],
        ['state','开启'],
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','名称必须']],
        ['user_group_id',null],
        ['type','管理员',['in:管理员','类型值错误']],
        ['password',null],
        ['duplicatePassword',null],
        ['avatar',null],
        ['sort',100,['number','排序必须数字']],
        ['state','开启',['in:开启,关闭','状态值错误']],
    ];
}