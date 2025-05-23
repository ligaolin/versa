<?php

namespace app\api\controller\other;

use app\api\controller\Base;
use think\facade\Db;

class Welcome extends Base
{
    function Index(){
        return self::Success('获取成功',['data'=>[
            ['name'=>'服务器系统类型','val'=>php_uname('s')],
            ['name'=>'服务器系统版本号','val'=>php_uname('r')],
            ['name'=>'服务器语言','val'=>$_SERVER['HTTP_ACCEPT_LANGUAGE']],
            ['name'=>'服务器地址','val'=>$_SERVER['SERVER_ADDR']],
            ['name'=>'服务器端口','val'=>$_SERVER['SERVER_PORT']],
            ['name'=>'域名','val'=>$_SERVER['HTTP_HOST']],
            ['name'=>'当前登录IP','val'=>$_SERVER['REMOTE_ADDR']],

            ['name'=>'服务器解译引擎','val'=>$_SERVER['SERVER_SOFTWARE']],
            ['name'=>'MYSQL版本','val'=>Db::query("SELECT VERSION() as version")[0]['version']],
            ['name'=>'PHP版本','val'=>PHP_VERSION],
            ['name'=>'PHP运行方式','val'=>php_sapi_name()],
            ['name'=>'Zend版本','val'=>Zend_Version()],

            ['name'=>'上传文件最大限制','val'=>ini_get('upload_max_filesize')],
            ['name'=>'POST最大限制','val'=>ini_get('post_max_size')],
            ['name'=>'内存使用量','val'=>ini_get('memory_limit')],
            ['name'=>'最大执行时间限制','val'=>ini_get('max_execution_time').'s'],
        ]]);
    }
}
