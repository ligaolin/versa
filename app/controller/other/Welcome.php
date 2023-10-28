<?php

namespace app\controller\other;

use app\controller\Base;

class Welcome extends Base
{
    function index(){
        // return self::ResData($_SERVER);
        return self::Success('获取成功',['data'=>[
            ['name'=>'服务器系统类型','val'=>php_uname('s')],
            ['name'=>'服务器系统版本号','val'=>php_uname('r')],
            ['name'=>'服务器解译引擎','val'=>$_SERVER['SERVER_SOFTWARE']],
            ['name'=>'服务器语言','val'=>$_SERVER['HTTP_ACCEPT_LANGUAGE']],
            ['name'=>'服务器地址','val'=>$_SERVER['SERVER_ADDR']],
            ['name'=>'服务器端口','val'=>$_SERVER['SERVER_PORT']],
            ['name'=>'域名','val'=>$_SERVER['SERVER_NAME']],

            ['name'=>'PHP版本','val'=>PHP_VERSION],
            ['name'=>'PHP运行方式','val'=>php_sapi_name()],
            ['name'=>'Zend版本','val'=>Zend_Version()],

            ['name'=>'当前登录IP','val'=>$_SERVER['REMOTE_ADDR']],
        ]]);
    }
}
