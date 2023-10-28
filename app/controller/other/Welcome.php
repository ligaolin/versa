<?php

namespace app\controller\other;

use app\controller\Base;

class Welcome extends Base
{
    function index(){
        // return self::ResData($_SERVER);
        return self::Success('获取成功',['data'=>[
            ['name'=>'服务器操作系统','val'=>$_SERVER['HTTP_SEC_CH_UA_PLATFORM']],
            ['name'=>'服务器软件','val'=>$_SERVER['SERVER_SOFTWARE']],
            ['name'=>'服务器端口','val'=>$_SERVER['SERVER_PORT']],
            ['name'=>'服务器地址','val'=>$_SERVER['SERVER_NAME']],
            ['name'=>'服务器软件','val'=>$_SERVER['SERVER_SOFTWARE']],
            ['name'=>'服务器软件','val'=>$_SERVER['SERVER_SOFTWARE']],
        ]]);
    }
}
