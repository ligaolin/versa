<?php

namespace app\controller\user;

use app\controller\Base;
use app\api\user\UserApi;
use think\facade\Db;

class User extends Base
{
    public function AddAdmin()
    {
        $data = UserApi::Get(UserApi::$UserGet);
        dump($data);
        return ' d';
    }
}
