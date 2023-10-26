<?php

namespace app\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use think\facade\Db;

class Admin
{
    public function handle($request, \Closure $next)
    {
        try{
            if(!$request->token = $request->header('Authorization')) throw new \Exception();

            // 角色验证
            $decoded = JWT::decode($request->token, new Key(env('JWT_KEY'), 'HS256'));
            if(!$decoded || !isset($decoded->id) || !$decoded->id) throw new \Exception();

            if(!isset($decoded->time) || !$decoded->time) throw new \Exception('登录过期');
            if(intval($decoded->time)+intval(env('JWT_EXPIR')) < time()) throw new \Exception('登录过期');

            $request->user = Db::table('user')->where('id', $decoded->id)->find();
            if(!$request->user) throw new \Exception('角色信息不存在');

            // 路由授权验证
            if($request->user['id']!=1){
                $route = $request->baseUrl();
                $prefix = '/api/';
                if (substr($route, 0, strlen($prefix)) == $prefix) $route = substr($route, strlen($prefix));
                if(!in_array($route,[
                    'admin/user.User/AdminLoginOut',
                    'admin/user.User/ChangePassword',
                    'admin/setting.Config/CacheClear',
                    'admin/user.User/Me',
                ])){
                    if($request->user['state']!='开启') throw new \Exception('管理员已被关闭',1200);
                    if(!$request->user['user_group_id']) throw new \Exception('缺少管理员组信息',1200);

                    if(!$auth_id = Db::table('user_auth')->where('route', $route)->where('state','开启')->value('id')) throw new \Exception('查询不到权限信息',1200);

                    if(!Db::table('user_group')->where('id', $request->user['user_group_id'])->where('auth_ids','like','%,'.$auth_id.'%')->where('state','开启')->find()) throw new \Exception('您没有该权限',1200);
                }
            }

            return $next($request);
        }catch(\Exception $e){
            $code = $e->getCode();
            if(!$code) $code = 1100;
            if($e->getMessage() == '登录过期') throw new \Exception('登录过期',$code);
            throw new \Exception('您没有访问权限',$code);
        }
    }
}