<template>
<template v-for="item in list">
    <el-sub-menu :index="item.id+''" v-if="item.children && item.children.length" >
        <template #title >
            <span @click="goUrl(item)">
                <el-icon v-if="item.level==1"><component :is="item.icon"></component></el-icon>
                <span>{{item.name}}</span>
            </span>
        </template>
        <adminMenu :data="item.children"></adminMenu>
    </el-sub-menu>
    <el-menu-item :index="item.id+''" @click="goUrl(item)" v-if="!item.children || !item.children.length" >
        <el-icon v-if="item.level==1"><component :is="item.icon"></component></el-icon>
        <span>{{item.name}}</span>
    </el-menu-item>
</template>
</template>
<script setup>
import adminMenu from './adminMenu.vue'
import { useRouter } from 'vue-router'
const props = defineProps(['data'])
const list = props.data
const router = useRouter()
const goUrl = item=>{
    if(item.type == '页面') router.push('/'+item.path)
}
</script>