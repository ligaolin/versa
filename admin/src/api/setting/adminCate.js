import Request from '@/utils/request'

// 获取后台栏目
export const adminCate = async param => { return await Request.post("setting.AdminCate/List",param) }
