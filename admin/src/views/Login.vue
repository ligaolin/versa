<template>
<div class="bg" :style="bg">
    <div class="form">
        <div>VERSA</div>
        <div><el-input v-model="name" :prefix-icon="User" placeholder="用户名" /></div>
        <div><el-input v-model="password" :prefix-icon="Lock" placeholder="密码" show-password /></div>
        <div>
            <el-input class="code" v-model="code" :prefix-icon="Lock" placeholder="验证码" />
            <el-image @click="getCode" class="code_img" :src="answer" />
        </div>
        
        <el-button type="primary" @keyup.enter.native="submit" @click="submit">登录</el-button>
        <div class="version">版本：{{ version }}</div>
        <div class="desc">通用快速后台管理系统</div>
    </div>
    <i class="el-icon-edit"></i>
</div>
</template>

<script setup>
import { reactive,ref,onMounted,onBeforeUnmount } from 'vue'
import { User, Lock } from '@element-plus/icons-vue'
import router from '@/router'
import { Random } from '@/utils/math'
import { adminLogin,getImgCode } from '@/api/account.js'
import { setItem } from '@/utils/store.js'
import BgImg1 from '@/assets/images/bg1.jpg'
import BgImg2 from '@/assets/images/bg2.jpg'
import BgImg3 from '@/assets/images/bg3.jpg'
import BgImg4 from '@/assets/images/bg4.jpg'
import BgImg5 from '@/assets/images/bg5.jpg'
import BgImg6 from '@/assets/images/bg6.jpg'
import BgImg7 from '@/assets/images/bg7.jpg'
import BgImg8 from '@/assets/images/bg8.jpg'
const BgImg = [BgImg1,BgImg2,BgImg3,BgImg4,BgImg5,BgImg6,BgImg7,BgImg8][Random(0,7)]
const bg = reactive({
    background: "url('"+BgImg+"') no-repeat",
    backgroundSize:'cover',
    backgroundPosition:'center'
})
const name = ref("")
const password = ref("")
const code = ref("")
const answer = ref("")
const code_id = ref("")
const version = "v1.0"
const submit = ()=>{
    adminLogin(name.value,password.value,code.value,code_id.value).then(res=>{
        console.log(res);
        getCode()
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            setItem('adminToken',res.token)
            res.user.token = res.token
            setItem('adminData',JSON.stringify(res.user))
            setTimeout(() => {
                router.push('/home')
            }, 1000)
        }else{
            ElMessage({message:res.msg,type:'warning'})
        }
    })
}

const getCode = ()=>{
    getImgCode().then(res=>{
        if(res.code == 2000){
            answer.value = res.answer
            code_id.value = res.id
        }
    })
}

const enterEvent = (ev)=>{
    if (ev.keyCode === 13) submit()
}
onMounted(()=>{
    getCode()
    window.addEventListener('keydown', enterEvent, true)
})
onBeforeUnmount(()=>{
    window.removeEventListener('keydown', enterEvent, true)
})
</script>

<style scoped>
.bg{ height: 100vh; }
.form{ box-shadow: 0 0 20px 1px rgb(255 255 255 / 30%); border:solid 1px rgba(255 ,255, 255,0.3); width: 350px; padding: 30px 30px 40px; background: rgba(0,0,0,0.5); position: absolute; top: calc(50% - 189px); left: calc(50% - 165px); }
.form>div:first-child{ color: #05b2c3; font-size: 42px; font-weight: bold; text-align: center; margin-bottom: 20px; }
.el-input{ margin-bottom: 20px; height: 40px; }
.el-button{ width: 100%; height: 40px; }
.version{ text-align: center; margin-top: 25px; color: #dfdfdf; }
.desc{ text-align: center; margin-top: 8px; color: #dfdfdf; }
.code{width:180px;vertical-align:top;}
.code_img{width: 100px; margin-left: 8px; height: 41px; border-radius: 4px;}
</style>