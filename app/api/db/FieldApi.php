<?php

namespace app\api\db;

use app\api\Base;

class FieldApi extends Base {
    static $Get = [
        ['id',null],
    ];

    static $List = [
        ['id',null],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
    ];
}