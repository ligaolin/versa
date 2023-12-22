<?php

namespace app\controller\test;

use app\controller\Base;
use app\utils\File;

class Test extends Base
{
    function Index(){
        return self::Res('测试','测试',2000);
    }
}