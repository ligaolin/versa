import { SetUrl } from '@/utils/data'
const api = [
    // 后台栏目
    ['AdminCateGetListByPid','setting.AdminCate/GetListByPid'], // 获取通过pid后台栏目列表
    ['adminCateGet','setting.AdminCate/Get'],
    ['AdminCateList','setting.AdminCate/List'],
    ['AdminCateEdit','admin/setting.AdminCate/Edit'],
    ['AdminCateChange','admin/setting.AdminCate/Change'],
    ['AdminCateDel','admin/setting.AdminCate/Del'],
    
    // ['addTable','admin/setting/AddTable'], //  
]

export const Post = (key,param) => {
    return SetUrl(api,key,param)
}