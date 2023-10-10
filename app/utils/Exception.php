<?php

namespace app\utils;

use think\exception\Handle;
use think\Response;
use Throwable;

class Exception extends Handle{
    public function render($request, Throwable $e): Response
    {
        return json([
            'msg'=>$e->getMessage(),
            'code'=>$e->getCode()?:1000,
            'line'=>$e->getLine(),
            'file'=>$e->getFile(),
        ], 200);
    }
}