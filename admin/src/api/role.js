import { SetUrl } from '@/utils/data'

const api = [
    // 用户
    ['UserGet','user.User/Get'],
    ['UserList','user.User/List'],
    // 管理员
    ['AdminLogin','user.User/AdminLogin'], // 登录
    ['AdminLoginOut','admin/user.User/AdminLoginOut'], // 退出登录
    ['UserAdminEdit','admin/user.User/AdminEdit'],
    ['UserAdminChange','admin/user.User/AdminChange'],
    ['UserAdminDel','admin/user.User/AdminDel'],

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
 