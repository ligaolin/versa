<?php

namespace app\api\param\db;

use app\api\param\Base;

class TableApi extends Base {
    static $List = [
        ['name',null],
        ['comment',null],
    ];

    static $Add = [
        ['name',null,['require','名称必须'],['alphaDash','数据表名只能是字母、数字、下划线（_）和及破折号（-）的组合']],
        ['comment',null],
    ];

    static $Edit = [
        ['oldName',null],
        ['name',null,['require','名称必须'],['alphaDash','数据表名只能是字母、数字、下划线（_）和及破折号（-）的组合']],
        ['comment',null],
    ];

    static $Del = [
        ['name',null,['require','名称必须']],
    ];
}