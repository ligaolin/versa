import { getItem } from '@/utils/store'

export const domain = 'localhost:8800'
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