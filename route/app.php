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

    ['action'=>'user.User','base'=>['Get','List','AdminLogin'],'admin'=>['Edit','AdminLoginOut']], // 用户管理
    
    ['action'=>'user.UserGroup','base'=>['Get','List'],'admin'=>['Edit','Change','Del']], // 用户组
    ['action'=>'user.UserAuth','base'=>['Get','List'],'admin'=>['Edit','Change','Del']], // 用户权限

    ['action'=>'db.Table','admin'=>['Edit','List','Add','Del']], // 数据表
    ['action'=>'db.Field','admin'=>['List','Add','Edit','Del']], // 表字段
    ['action'=>'setting.AdminCate','base'=>['Get','List','GetListByPid'],'admin'=>['Edit','Change','Del']], // 后台栏目
]);