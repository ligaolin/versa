<?php

namespace app\api\setting;

use app\api\Base;

class ContentFieldApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
        ['cname',null],
    ];

    static $List = [
        ['id',null],
        ['content_id',null,['require','所属自定义内容必须']],
        ['content_name',null],
        ['name',null],
        ['cname',null],
        ['type',null],
        ['is_null',null],
        ['is_repeat',null],
        ['default',null],
        ['table',null],
        ['field',null],
        ['state',null],

        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['content_id',null,['require','所属自定义内容必须']],
        ['name',null,['require','英文名称必须']],
        ['cname',null],

        ['type',null,['require','数据类型必须']],
        ['is_null','可以',['in:可以,不可以','可否为空值错误']],
        ['is_repeat','可以',['in:可以,不可以','可否重复值错误']],
        ['default',null],
        ['vals',null],
        ['tips',null],
        ['table',null],
        ['field',null],
        ['field_name',null],
    ];

    static $Del = [
        ['id',null,['require','id名称必须']],
    ];
}