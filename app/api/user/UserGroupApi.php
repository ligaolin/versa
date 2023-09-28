<?php

namespace app\api\user;

use app\api\Base;

class UserGroupApi extends Base {
    static $Edit = [
        ['id',null],
        ['name',null,['require','名称必须']],
        ['auth_ids',null],
        ['sort',100],
        ['state','开启'],
    ];
}