<?php

namespace app\api\param\setting;

use app\api\param\Base;

class ConfigApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
    ];

    static $List = [
        ['id',null],
        ['name',null],
        ['type',null],
        ['field_type',null],

        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','名称必须']],
        ['val',null],
        ['type',null],
        ['field_type','单行文本'],
        ['vals',null],
    ];
}