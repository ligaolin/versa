import Request from '@/utils/request'

// 获取后台栏目列表
export const adminCate = async param => { return await Request.post("setting.AdminCate/List",param) }

// 通过pid获取后台栏目，包含所有子级
export const GetAdminCateByPid = async param => { return await Request.post("setting.AdminCate/GetListByPid",param) }

// 获取后台栏目单条数据
export const getAdminCateById = param => { return Request.post("setting.AdminCate/Get",param) }

// 添加编辑后台栏目
export const editAdminCate = param => { return Request.post("admin/setting.AdminCate/Edit",param) }

// 删除后台栏目
export const delAdminCate = param => { return Request.post("admin/setting.AdminCate/Del",param) }