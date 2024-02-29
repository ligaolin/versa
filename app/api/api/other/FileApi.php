<?php

namespace app\api\api\other;

use app\api\Base;

class FileApi extends Base {
    static $List = [
        ['dir',null],
        ['name',null],
    ];

    static $Del = [
        ['path',null,['require','路径必须']],
    ];

    static $Change = [
        ['path',null,['require','路径必须']],
        ['newName',null,['require','新名称必须']],
    ];

    static $Add = [
        ['path',null,['require','路径必须']],
        ['name',null,['require','名称必须']],
    ];
}