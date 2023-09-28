<?php

namespace app\api\user;

use app\api\Base;

class UserApi extends Base {
    static $name;

    static function rule(){
        return [
            ['name',[
                ['require','名称必须'],
                // ['number','年龄必须是数字'],
                // ['max:25','名称最多不能超过25个字符'],
                // ['between:1,120','年龄只能在1-120之间'],
            ]],
        ];
    }
}