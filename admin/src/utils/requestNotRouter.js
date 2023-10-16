import axios from 'axios'
import { http } from '@/data'

axios.defaults.baseURL = http + "/api/"
axios.interceptors.request.use(config => { // 添加请求拦截器
    config.headers.Authorization = localStorage.getItem('adminToken')
    return config
}, function (error) {
    return Promise.reject(error)
});

export default axios