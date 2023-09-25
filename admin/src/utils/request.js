import axios from 'axios'
import { http } from '@/data'
import router from '@/router'

axios.defaults.baseURL = http + "/api/"
axios.interceptors.request.use(config => { // 添加请求拦截器
    config.headers.Authorization = localStorage.getItem('adminToken')
    return config
}, function (error) {
    return Promise.reject(error)
});

axios.interceptors.response.use(res => { // 响应拦截
    if (res.data.code == 1100) {
        ElMessage({message:res.data.msg,type:'warning'})
        setTimeout(() => {
            router.push('/login')
        }, 1000)
    }
    return res.data
}, err => {
    return Promise.reject(err)
})

export default axios