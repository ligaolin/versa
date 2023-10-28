<?php

namespace app\controller\other;

use app\controller\Base;
use app\utils\File as UtFile;

class File extends Base
{
    function Upload(){
        $res['data'] = UtFile::Upload();
        return self::Success('上传完成',$res);
    }
}