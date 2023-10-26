import { SetUrl } from '@/utils/request'
const api = [
    // 后台栏目
    ['AdminCateGetListByPid','setting.AdminCate/GetListByPid'], // 获取通过pid后台栏目列表
    ['adminCateGet','admin/setting.AdminCate/Get'],
    ['AdminCateList','setting.AdminCate/List'],
    ['AdminCateListAuth','admin/setting.AdminCate/List'], // 需要权限
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
    ['UserGet','admin/user.User/Get'],
    ['UserList','admin/user.User/List'],
    // 管理员
    ['AdminLogin','user.User/AdminLogin'], // 登录
    ['AdminLoginOut','admin/user.User/AdminLoginOut'], // 退出登录
    ['UserAdminEdit','admin/user.User/AdminEdit'],
    ['UserAdminChange','admin/user.User/AdminChange'],
    ['UserAdminDel','admin/user.User/AdminDel'],
    ['UserAdminMe','admin/user.User/Me'], // 我的信息
    ['UseradminChangePassword','admin/user.User/ChangePassword'], // 修改密码

    // 用户组
    ['UserGroupGet','admin/user.UserGroup/Get'],
    ['UserGroupList','admin/user.UserGroup/List'],
    // 管理员组
    ['UserGroupAdminEdit','admin/user.UserGroup/AdminEdit'],
    ['UserGroupAdminChange','admin/user.UserGroup/AdminChange'],
    ['UserGroupAdminDel','admin/user.UserGroup/AdminDel'],

    // 用户权限
    ['UserAuthGet','admin/user.UserAuth/Get'],
    ['UserAuthList','admin/user.UserAuth/List'],
    ['UserAuthGetListByPid','admin/user.UserAuth/GetListByPid'],
    
    // 管理员权限
    ['UserAuthAdminEdit','admin/user.UserAuth/AdminEdit'],
    ['UserAuthAdminChange','admin/user.UserAuth/AdminChange'],
    ['UserAuthAdminDel','admin/user.UserAuth/AdminDel'],

    ['FileUpload','admin/other.File/Upload'],

    // 配置
    ['ConfigGet','admin/setting.Config/Get'],
    ['ConfigList','setting.Config/List'],
    ['ConfigGetAuth','admin/setting.Config/Get'], // 需要权限
    ['ConfigListAuth','admin/setting.Config/List'], // 需要权限
    ['ConfigEdit','admin/setting.Config/Edit'],
    ['ConfigChange','admin/setting.Config/Change'],
    ['ConfigDel','admin/setting.Config/Del'],
    ['ConfigForEditVal','admin/setting.Config/ForEditVal'],
    ['ConfigCacheClear','admin/setting.Config/CacheClear'],
]

export const Post = (key,param) => {
    return SetUrl(api,key,param)
}