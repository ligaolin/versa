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

            // url验证


            $request->user = Db::table('user')->where('id', $decoded->id)->find();
            if(!$request->user) throw new \Exception('角色信息不存在');

            return $next($request);
        }catch(\Exception $e){
            if($e->getMessage() == '登录过期') throw new \Exception('登录过期',1100);
            throw new \Exception('您没有访问权限',1100);
        }
    }
}