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

Route::SetRoute('api',[
    ['action'=>'test.Test','base'=>['Index'],'method'=>'get'], // 测试

    ['action'=>'other.Captcha','base'=>['Img'],'method'=>'get'], // 验证码
    ['action'=>'other.Upload','admin'=>['Index']], // 文件
    ['action'=>'other.File','admin'=>['List','Del','Change','Add']], // 文件
    ['action'=>'other.Welcome','admin'=>['Index']], // 欢迎

    ['action'=>'user.User','base'=>['AdminLogin'],'admin'=>['AdminEdit','AdminChange','AdminDel','Get','List','ChangePassword','AdminLoginOut','Me']], // 用户管理
    ['action'=>'user.UserGroup','admin'=>['AdminEdit','AdminChange','AdminDel','Get','List']], // 用户组
    ['action'=>'user.UserAuth','admin'=>['AdminEdit','AdminChange','AdminDel','Get','List','GetListByPid']], // 用户权限

    ['action'=>'db.Table','admin'=>['Edit','List','Add','Del','Backups']], // 数据表
    ['action'=>'db.Field','admin'=>['List','Add','Edit','Del']], // 表字段
    ['action'=>'setting.AdminCate','base'=>['GetListByPid','List'],'admin'=>['Edit','Change','Del','Get','List']], // 后台栏目
    ['action'=>'setting.Config','base'=>['Get','List'],'admin'=>['Edit','Change','Del','Get','List','ForEditVal','CacheClear']], // 配置
    ['action'=>'setting.ConfigType','admin'=>['Edit','Change','Del','List']], // 配置

    ['action'=>'setting.Content','admin'=>['Get','Edit','Change','Del','List']], // 自定义内容
    ['action'=>'setting.ContentField','admin'=>['Get','Edit','Change','Del','List']], // 自定义内容字段
]);