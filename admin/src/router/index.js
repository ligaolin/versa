import { createRouter, createWebHistory } from 'vue-router'
import { adminCate } from '@/api/setting/adminCate'

let routes = [
    { path: '/login', meta:{title:"后台登录"}, component: () => import('@/views/login.vue') },
    { path: '/', meta:{title:"后台首页"}, component: () => import('@/views/home.vue'),children:[]},
]

let res = await adminCate({type:"页面"})
if(res.code==2000){
    for(let i in res.data){
        routes[1].children.push({ path: '/'+res.data[i].Path, meta:{title:res.data[i].Name}, component: () => import(res.data[i].View)})
    }
}


const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})

export default router
