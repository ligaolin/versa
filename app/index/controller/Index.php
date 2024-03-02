<?php

namespace app\index\controller;

use app\index\controller\Base;

class Index extends Base
{
    function index(){
        return view('index/index');
    }
}