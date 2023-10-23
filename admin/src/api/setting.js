import { SetUrl } from '@/utils/data'
const api = [
    // 后台栏目
    ['AdminCateGetListByPid','setting.AdminCate/GetListByPid'], // 获取通过pid后台栏目列表
    ['adminCateGet','setting.AdminCate/Get'],
    ['AdminCateList','setting.AdminCate/List'],
    ['AdminCateEdit','admin/setting.AdminCate/Edit'],
    ['AdminCateChange','admin/setting.AdminCate/Change'],
    ['AdminCateDel','admin/setting.AdminCate/Del'],
    
    // 数据表
    ['TableEdit','admin/db.Table/Edit'],
    ['TableList','admin/db.Table/List'],
    ['TableAdd','admin/db.Table/Add'],
    ['TableDel','admin/db.Table/Del'],

    // 数据表字段
    ['FieldEdit','admin/db.Field/Edit'],
    ['FieldList','admin/db.Field/List'],
    ['FieldAdd','admin/db.Field/Add'],
    ['FieldDel','admin/db.Field/Del'],
]

export const Post = (key,param) => {
    return SetUrl(api,key,param)
}