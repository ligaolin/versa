import Request from '@/utils/request'
import { SetUrl } from '@/utils/data'

const api = [
    ['adminLogin','user.User/AdminLogin'], // 登录

    ['adminLoginOut','admin/account/AdminLoginOut'], // 退出登录

    ['getAdminCateById','setting.AdminCate/Get'],
    ['editAdminCate','admin/setting.AdminCate/Edit'],
    ['delAdminCate','admin/setting.AdminCate/Del'],
    ['getAdmin','admin/account/GetAdmin'], // 会员信息
]

export const Post = (key,param) => {
    return SetUrl(api,key,param)
}
 