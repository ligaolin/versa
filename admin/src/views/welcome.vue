<template>
<div class="title">系统信息</div>
<el-table class="listTable" border :data="list" :show-header="false">
    <el-table-column prop="name" label="信息" />
    <el-table-column prop="val" label="值" />
</el-table>
</template>

<script setup>
import { ref } from 'vue'
import { Post } from '@/api/api'

const list = ref([])
Post('Welcome').then(res=>{
    if(res.code==2000) list.value = res.data
})
</script>

<style scoped>
.title{font-weight:bold;font-size:18px;margin-bottom:20px;text-align:center;margin-top:20px;}
</style>