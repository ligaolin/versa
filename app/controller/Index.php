<?php

namespace app\controller;

use app\BaseController;
use think\facade\Db;

class Index extends BaseController
{
    public function index()
    {
        $data = Db::table('test')->where('id', 1)->find();
        throw new \Exception('ddd');
        return ' d';
    }

    public function hello($name = 'ThinkPHP8')
    {
        return 'hello,' . $name;
    }
}
