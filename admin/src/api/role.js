import { SetUrl } from '@/utils/data'

const api = [
    ['AdminLogin','user.User/AdminLogin'], // 管理员登录
    ['AdminLoginOut','admin/user.User/AdminLoginOut'], // 管理员退出登录

    // 用户
    ['UserGet','user.User/Get'],
    ['UserList','user.User/List'],
    ['UserEdit','admin/user.User/Edit'],
]

export const Post = (key,param) => {
    return SetUrl(api,key,param)
}
 