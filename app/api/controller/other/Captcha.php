<?php

namespace app\api\controller\other;

use app\api\controller\Base;
use app\utils\Captcha as UtoolCaptcha;
use app\api\api\other\CaptchaApi;

class Captcha extends Base
{
    function Img(){
        $data = CaptchaApi::Get(CaptchaApi::$Verify);
        return UtoolCaptcha::Set($data['width'],$data['height']);
    }
}