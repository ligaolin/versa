import Request from '@/utils/request'

// 获取后台栏目通过pid
export const getAdminCateByPid = param => { return Request.post("/admin/system/GetAdminCateByPid",param) }

// 获取后台栏目通过id
export const getAdminCateById = param => { return Request.post("/admin/system/GetAdminCateById",param) }

// 获取后台栏目
export const adminCate = async param => { return await Request.post("/system/GetAdminCate",param) }

// 添加编辑后台栏目
export const editAdminCate = param => { return Request.post("admin/system/EditAdminCate",param) }

// 删除后台栏目
export const delAdminCate = param => { return Request.post("/admin/system/DelAdminCate",param) }


// 添加数据表
export const addTable = ()=>{
    return Request.post("admin/system/AddTable")
}