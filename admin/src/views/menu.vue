<template>
<template v-for="item in list">
    <el-sub-menu :index="item.ID+''" v-if="item.children && item.children.length" >
        <template #title >
            <span @click="goUrl(item)">
                <el-icon v-if="item.Level==1"><component :is="item.Icon"></component></el-icon>
                <span>{{item.Name}}</span>
            </span>
        </template>
        <AdminMenu :data="item.children"></AdminMenu>
    </el-sub-menu>
    <el-menu-item :index="item.ID+''" @click="goUrl(item)" v-if="!item.children || !item.children.length" >
        <el-icon v-if="item.Level==1"><component :is="item.Icon"></component></el-icon>
        <span>{{item.Name}}</span>
    </el-menu-item>
</template>
</template>
<script setup>
import AdminMenu from './menu.vue'
import { useRouter } from 'vue-router'
const props = defineProps(['data'])
const list = props.data
const router = useRouter()
const goUrl = item=>{
    if(item.Type == '页面') router.push('/'+item.Path)
}
</script>