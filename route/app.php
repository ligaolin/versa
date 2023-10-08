<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
use app\utils\Route;

Route::SetRoute([
    ['action'=>'other.Captcha','base'=>['Img'],'method'=>'get'], // 验证码
    ['action'=>'user.User','base'=>['Get','List','AdminLogin'],'admin'=>['Edit']], // 用户管理
    ['action'=>'db.Table','base'=>['Edit']], // 用户管理
]);