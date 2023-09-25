import Request from '@/utils/request'

// 登录
export const adminLogin = (name,password,code,code_id)=>{
    return Request.post("account/AdminLogin",{ name:name, password:password, code:code, code_id:code_id, })
}

// 获取图片验证码
export const getImgCode = (width='100',height='200')=>{
    return Request.post("account/CaptchaImage",{width:width,height:height})
}

// 退出登录
export const adminLoginOut = ()=>{
    return Request.post("/admin/account/AdminLoginOut")
}

// 会员信息
export const getAdmin = (id=0)=>{
    return Request.post(".admin/account/GetAdmin",{ id:id, })
}