import { createRouter, createWebHistory } from 'vue-router'

let routes = [
    { path: '/', redirect: '/welcome' },
    { path: '/login', meta:{title:"后台登录"}, component: () => import('@/views/login.vue') },
    { path: '/home',name:'home', meta:{title:"后台首页"}, component: () => import('@/views/home.vue'),children:[
        {path:'/welcome', meta:{title:'欢迎'}, component:()=>import('../views/welcome.vue')},
    ]},
]

import { defineAsyncComponent } from 'vue'
import { Post } from '@/api/api'
const modules = import.meta.glob('../views/**/*.vue')

let res = await Post('AdminCateList',{type:"页面"})
if(res.code==2000){
    for(let i in res.data){
        if(modules[res.data[i].view]) routes[2].children.push({ path: '/'+res.data[i].path.split('?')[0], meta:{title:res.data[i].name}, component:defineAsyncComponent(modules[res.data[i].view])})
    }
}

const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: routes,
})

export default router
