<?php

namespace app\api\user;

use app\api\Base;

class UserApi extends Base {
    static $UserGet = [
        ['name',null,
            ['require','名称必须'],
            ['number','年龄必须是数字'],
            ['max:25','名称最多不能超过25个字符'],
            ['between:1,120','年龄只能在1-120之间'],
        ],
        ['key',81,
            ['require','关键词必须'],
            ['max:25','关键词最多不能超过25个字符'],
        ],
        ['kdf',81],
        ['fsdg',81],
    ];

    static $AddAdmin = [
        ['name',null,
            ['require','名称必须'],
            ['number','年龄必须是数字'],
            ['max:25','名称最多不能超过25个字符'],
            ['between:1,120','年龄只能在1-120之间'],
        ],
        ['key',81,
            ['require','关键词必须'],
            ['max:25','关键词最多不能超过25个字符'],
        ],
        ['kdf',81],
        ['fsdg',81],
    ];
}