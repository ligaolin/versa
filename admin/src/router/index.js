import { createRouter, createWebHistory } from 'vue-router'

let routes = [
    { path: '/', redirect: '/home' },
    { path: '/login', meta:{title:"后台登录"}, component: () => import('@/views/login.vue') },
    { path: '/home',name:'home', meta:{title:"后台首页"}, component: () => import('@/views/home.vue'),children:[]},
]

import { Post } from '@/api/api'

let res = await Post('AdminCateList',{type:"页面"})
if(res.code==2000){
    for(let i in res.data){
        routes[2].children.push({ path: '/'+res.data[i].path, meta:{title:res.data[i].name}, component: () => import(res.data[i].view)})
    }
}

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})

export default router
