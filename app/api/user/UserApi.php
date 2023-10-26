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
        ['group_name',null],
        
        ['state','开启'],
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','名称必须']],
        ['user_group_id',null],
        ['password',null],
        ['duplicatePassword',null],
        ['avatar',null],
    ];

    static $AdminLogin = [
        ['name',null,['require','名称必须']],
        ['password',null,['require','密码必须']],
        ['code',null,['require','验证码必须']],
    ];

    static $ChangePassword = [
        ['originalPassword',null,['require','原密码必须']],
        ['password',null,['require','密码必须']],
        ['duplicatePassword',null,['require','重复密码必须']],
    ];
}