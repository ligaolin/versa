<?php

namespace app\controller\other;

use app\controller\Base;
use app\utils\Upload as UtUpload;
use app\api\other\UploadApi;

class Upload extends Base
{
    function Index(){
        $data = UploadApi::Get(UploadApi::$Index);
        $res['data'] = UtUpload::Upload($data['dir']);
        return self::Success('上传完成',$res);
    }
}