<?php

namespace app\api\api\setting;

use app\api\Base;

class ConfigTypeAPi extends Base {
    static $List = [
        ['id',null],
        ['name',null],
        ['type',null],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','类型名称必须']],
        ['type',null,['require','类型值必须']],
        ['edit','是',['in:是,否','可否修改值错误']],
    ];

    static $Del = [
        ['id',null,['require','id名称必须']],
    ];
}