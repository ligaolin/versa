<?php

namespace app\api\controller\test;

use app\api\controller\Base;
use app\utils\File;

class Test extends Base
{
    static function Index(){
        return self::Res('测试','测试',2000);
    }
}