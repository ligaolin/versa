<?php

namespace app\middleware;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class Admin
{
    public function handle($request, \Closure $next)
    {
        $jwt = $request->header('Authorization');

        $decoded = JWT::decode($jwt, new Key(env('JWT_KEY'), 'HS256'));
        if(!$decoded || !isset($decoded['id']) || !$decoded['id']) return json(null,1100,'您没有访问权限');

//         if()
// print_r($decoded);

        return $next($request);
    }
}