<?php

namespace app\controller\user;

use app\BaseController;
use app\api\user\UserApi;
use think\facade\Db;

class User extends BaseController
{
    public function index()
    {
        $data = UserApi::Get();
        dump(UserApi::$name);
        return json_encode($data);
        return ' d';
    }
}
