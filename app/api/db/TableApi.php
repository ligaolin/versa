<?php

namespace app\api\db;

use app\api\Base;

class TableApi extends Base {
    static $Edit = [
        ['id',null],
        ['name',null,['require','名称必须'],['alphaDash','只能是字母、数字、下划线（_）和及破折号（-）的组合']],
        ['cname',null,['require','中文名称必须']],
        ['sort',100],
        ['state','开启'],
    ];
}