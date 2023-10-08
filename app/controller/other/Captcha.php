<?php

namespace app\controller\other;

use app\controller\Base;
use app\utils\Captcha as UtoolCaptcha;
use app\api\other\CaptchaApi;

class Captcha extends Base
{
    function Img(){
        $data = CaptchaApi::Get(CaptchaApi::$Verify);
        return UtoolCaptcha::Set($data['width'],$data['height']);
    }
}