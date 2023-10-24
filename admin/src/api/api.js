import { SetUrl } from '@/utils/request'
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
    ['TableBackups','admin/db.Table/Backups'],

    // 数据表字段
    ['FieldEdit','admin/db.Field/Edit'],
    ['FieldList','admin/db.Field/List'],
    ['FieldAdd','admin/db.Field/Add'],
    ['FieldDel','admin/db.Field/Del'],

    // 用户
    ['UserGet','user.User/Get'],
    ['UserList','user.User/List'],
    // 管理员
    ['AdminLogin','user.User/AdminLogin'], // 登录
    ['AdminLoginOut','admin/user.User/AdminLoginOut'], // 退出登录
    ['UserAdminEdit','admin/user.User/AdminEdit'],
    ['UserAdminChange','admin/user.User/AdminChange'],
    ['UserAdminDel','admin/user.User/AdminDel'],
    ['UserAdminMe','admin/user.User/Me'], // 我的信息

    // 用户组
    ['UserGroupGet','user.UserGroup/Get'],
    ['UserGroupList','user.UserGroup/List'],
    // 管理员组
    ['UserGroupAdminEdit','admin/user.UserGroup/AdminEdit'],
    ['UserGroupAdminChange','admin/user.UserGroup/AdminChange'],
    ['UserGroupAdminDel','admin/user.UserGroup/AdminDel'],

    // 用户权限
    ['UserAuthGet','user.UserAuth/Get'],
    ['UserAuthList','user.UserAuth/List'],
    // 管理员权限
    ['UserAuthAdminEdit','admin/user.UserAuth/AdminEdit'],
    ['UserAuthAdminChange','admin/user.UserAuth/AdminChange'],
    ['UserAuthAdminDel','admin/user.UserAuth/AdminDel'],
]

export const Post = (key,param) => {
    return SetUrl(api,key,param)
}