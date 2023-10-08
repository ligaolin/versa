import { getItem } from '@/utils/store'

// export const domain = 'gmood.site'
export const domain = '127.0.0.1:8000'
export const http = 'http://' + domain
export const pageNum = 10

const initData = ()=>{
    getAdmin(false)
    getConfig(false)
}


const getAdmin = (cache=true)=>{
    let admin,token
    if(cache){
        token = getItem('adminToken')
        admin = getItem('adminData')
        if(admin && admin.token && token && admin.token==token) return admin
    }
    
}

const getConfig = (cache=true)=>{
    
}