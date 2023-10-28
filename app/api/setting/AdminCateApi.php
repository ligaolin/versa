<?php

namespace app\api\setting;

use app\api\Base;

class AdminCateApi extends Base {
    static $Get = [
        ['id',null],
        ['name',null],
    ];

    static $List = [
        ['id',null],
        ['name',null],
        ['pid',null],
        ['level',null],
        ['type',null],
        ['path',null],
        ['view',null],
        ['show',null],
        ['state','开启'],

        ['childId',null],
        ['childName',null],
        ['childPid',null],
        ['childLevel',null],
        ['childType',null],
        ['childPath',null],
        ['childView',null],
        ['childState',null],
        ['childShow',null],
        
        ['page',null],
        ['pageNum',10],
        ['order','sort asc,id asc'],
    ];

    static $GetListByPid = [
        ['pid',0,['require','上级ID必须']],
        ['name',null],
        ['type',null],
        ['path',null],
        ['view',null],
        ['show',null],
        ['state','开启'],
    ];

    static $Edit = [
        ['id',null,['number','id必须数字']],
        ['name',null,['require','名称必须']],
        ['pid',0,['require','上级ID必须']],
        ['level',1,['require','级别必须']],
        ['type',null,['require','类型必须'],['in:分类,页面','类型值错误']],
        ['path',null],
        ['active',null],
        ['view',null],
        ['icon',null],
        ['show','是',['in:是,否','是否显示值错误']],
    ];
}