import Request from '@/utils/request'

// 登录
export const adminLogin = (name,password,code)=>{
    return Request.post("user.User/AdminLogin",{ name:name, password:password, code:code, })
}

// 退出登录
export const adminLoginOut = ()=>{
    return Request.post("/admin/account/AdminLoginOut")
}

// 会员信息
export const getAdmin = (id=0)=>{
    return Request.post(".admin/account/GetAdmin",{ id:id, })
}