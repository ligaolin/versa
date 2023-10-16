<template>
    <el-container class="common">
        <el-aside class="comm_cate">
            <!-- 左边栏目 -->
            <el-menu default-active="2" class="el-menu-vertical-demo" :collapse="isCollapse">
                <div class="comm_logo">
                    <!-- <img src="https://element-plus.gitee.io/images/element-plus-logo.svg" alt=""> -->
                    {{isCollapse?'V':'VERSA'}}
                </div>
                <adminMenu v-if="cate.length" :data="cate"></adminMenu>
            </el-menu>
            <!-- 左边栏目 end -->
        </el-aside>
        <el-container>
            <el-header class="comm_head">
                <div class="comm_head_icon">
                    <el-icon @click="isCollapse=!isCollapse"><Operation /></el-icon>
                    <el-icon @click="refreshPage()"><Refresh /></el-icon>
                    <el-icon @click="handleFullScreen()"><full-screen /></el-icon>
                </div>
                <div class="comm_head_text">
                    <span><el-icon><Delete /></el-icon>清除缓存</span>
                    <span><el-icon><House /></el-icon>访问网站</span>
                    <span class="comm_head_admin">
                        <div>
                            <span>
                                <el-avatar :size="35" src="https://element-plus.gitee.io/images/element-plus-logo.svg" />
                            </span>
                            <span class="comm_head_admin_name">admin</span>
                            <el-icon><arrow-up /></el-icon>
                        </div>
                        <div>
                            <div><el-icon><Postcard /></el-icon>个人资料</div>
                            <div><el-icon><Lock /></el-icon>修改密码</div>
                            <div @click="loginOut"><el-icon><switch-button /></el-icon>退出登录</div>
                        </div>
                    </span>
                </div>
            </el-header>
            <el-container>
                <el-main class="comm_main">
                    <el-page-header @back="onBack" class="comm_cont">
                        <template #content>
                            <el-breadcrumb separator="/">
                                <el-breadcrumb-item>
                                    <a href="/"><el-icon><home-filled /></el-icon>首页</a>
                                </el-breadcrumb-item>
                                <el-breadcrumb-item v-if="page_title!='首页'">
                                    <a>{{ page_title }}</a>
                                </el-breadcrumb-item>
                            </el-breadcrumb>
                        </template>
                        <div>
                            <RouterView />
                        </div>
                    </el-page-header>
                </el-main>
            </el-container>
        </el-container>
    </el-container>
</template>

<script setup>
import { ref } from 'vue'
import { RouterView } from 'vue-router'
import { useRouter, useRoute } from 'vue-router'
import { adminLoginOut } from '@/api/account'
import adminMenu from './adminMenu.vue'
import { GetAdminCateByPid } from '@/api/setting/adminCate'
const cate = ref([])
GetAdminCateByPid({pid:0}).then(res=>{
    if(res.code==2000) cate.value = res.data
})

const router = useRouter(),route = useRoute()
const page_title = route.meta.title
const fullscreen = ref(true)
const isCollapse = ref(false)

const loginOut = ()=>{ // 退出登录
    adminLoginOut().then(res=>{
        if(res.code==2000){
            ElMessage({message:res.msg,type:'success'})
            localStorage.removeItem('adminToken')
            setTimeout(() => {
                router.push('/login')
            }, 1000)
        }else{
            ElMessage({message:res.msg,type:'warning'})
        }
    })
}
const onBack = ()=>{ // 返回上一页
    history.back()
}
const refreshPage = ()=>{ // 刷新页面
    location.reload()
}
const handleFullScreen = () =>{ // 全屏切换
    if(fullscreen.value){ // 全屏
        if (document.documentElement.requestFullscreen) {
            document.documentElement.requestFullscreen()
        } else if (document.documentElement.mozRequestFullScreen) {
            document.documentElement.mozRequestFullScreen()
        } else if (document.documentElement.webkitRequestFullscreen) {
            document.documentElement.webkitRequestFullscreen()
        } else if (document.documentElement.msRequestFullscreen) {
            document.documentElement.msRequestFullscreen()
        }
    }else{ // 退出全屏
        if (document.exitFullscreen) {
            document.exitFullscreen()
        } else if (document.mozCancelFullScreen) {
            document.mozCancelFullScreen()
        } else if (document.webkitExitFullscreen) {
            document.webkitExitFullscreen()
        }
    }
    fullscreen.value = !fullscreen.value
}
</script>

<style scoped>
.common{height:100vh;}
.comm_head{height:50px !important;line-height:50px;}
.comm_cate{width:unset !important;}
.comm_cate>.el-menu{height:100vh;max-width:240px;}
.comm_logo{padding: 10px 20px; height: 60px; font-size: 24px; font-weight: bold; line-height: 40px; text-align: center; color: #0b8e9b;}
.comm_logo>img{width:100%;height:100%;}

.comm_head{width:100%;display: inline-flex;justify-content: space-between;line-height: 50px;border-bottom: solid 1px #dcdfe6;}
.comm_head_icon>i{margin-right: 30px;vertical-align: middle;font-size: 20px;cursor: pointer;}
.comm_head_icon>i:first-child{font-size: 22px;color: #787878;}
.comm_head_icon>i:hover{color: #0b8e9b;}
.comm_head_text>span{margin-left: 30px;cursor: pointer;padding: 0 5px;}
.comm_head_text>span:hover{color: #0b8e9b;}
.comm_head_text>span>i,.comm_head_admin:hover>div:last-child>div>i{font-size: 16px;vertical-align: middle;margin-bottom: 3px;margin-right:2px;}

.comm_head_admin{position: relative;display: inline-block;}
.comm_head_admin .el-avatar{vertical-align: middle;background: #ebebeb;}
.comm_head_admin>div:last-child{position: absolute;box-shadow: 0 0 6px 0 #cbcbcb;right: 0;width:110px;text-align: center;line-height:35px;display:none;width: 100%;background-color: white;}
.comm_head_admin>div:last-child>div:first-child{margin-top: 10px;}
.comm_head_admin>div:last-child>div:nth-child(2){margin-bottom: 10px;}
.comm_head_admin>div:last-child>div:last-child{border-top: solid 1px #ebebeb;padding: 5px 0;}
.comm_head_admin:hover>div:last-child{color:#333;display: block;}
.comm_head_admin:hover>div:first-child .el-icon{transform:rotate(180deg);}
.comm_head_admin:hover>div:last-child>div:hover{color:#0b8e9b;}
.comm_head_admin_name{margin: 0 5px;}
.comm_head_admin .el-icon{vertical-align:middle;margin-bottom: 2px;}

.comm_main{background-color:#f5f5f5;padding:15px !important;}
.comm_cont{background-color: white;padding: 15px;height: calc(100vh - 80px);}
.el-breadcrumb .el-icon{ color: #9f9f9f; float: left; font-size: 15px; vertical-align: middle; margin-right: 4px;}
.comm_cont>div:last-child{overflow-y: auto; height: calc(100vh - 160px); margin-top: 15px;}
</style>