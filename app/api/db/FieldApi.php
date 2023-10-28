<?php

namespace app\api\db;

use app\api\Base;

class FieldApi extends Base {
    static $List = [
        ['table',null,['require','表名称必须']],

        ['name',null],
        ['type',null],
        ['isNull',null],
        ['default',''],
        ['comment',null],
        ['key',null],
    ];

    static $Add = [
        ['table',null,['require','表名称必须']],
        ['name',null,['require','字段名称必须']],
        ['type',null,['require','字段类型必须']],
        ['isNull',null],
        ['default',null],
        ['comment',null],
        ['key',null],
    ];

    static $Edit = [
        ['table',null,['require','表名称必须']],
        ['oldName',null,['require','旧字段名称必须']],
        ['name',null,['require','字段名称必须']],
        ['type',null,['require','字段类型必须']],
        ['isNull',true],
        ['default',null],
        ['comment',null],
        ['key',null],
    ];

    static $Del = [
        ['table',null,['require','表名称必须']],
        ['name',null,['require','字段名称必须']],
    ];
}