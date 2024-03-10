<template>
    <list :getData="getData" :editPage="edit" ref="listEleme" rowKey="name" :page="false">
        <template #search>
            <label>数据表名称：<el-input clearable v-model="name"/></label>
            <label>数据表注释：<el-input clearable v-model="comment"/></label>
        </template>

        <template #operation="{ ids }">
            <el-button type="primary" @click="addEdit()">添加</el-button>
            <el-button type="danger" @click="Del(ids)">批量删除</el-button>
            <!-- <el-button @click="Backups()">数据库备份</el-button> -->
        </template>

        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="name" label="数据表名称" align="center"/>
        <el-table-column prop="comment" label="数据表注释" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button type="primary" size="small" @click="fieldPage(scope.row)">字段</el-button>
                <el-button type="primary" size="small" @click="addEdit(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="Del(scope.row.name)">删除</el-button>
            </template>
        </el-table-column>
    </list>

</template>

<script setup>
import edit from "./edit.vue"
import { Post } from "@/api/api"
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

const name = ref("")
const comment = ref("")
const getData = ()=>{
    let param = {pid : 0}
    if(name.value) param.name = name.value
    if(comment.value) param.comment = comment.value
    return ['TableList',param]
}

const listEleme = ref(null)
const Del = (ids)=>{
    listEleme.value.Del('TableDel',ids,'name')
}

const addEdit = (item={}) => {
    if(item.name) {
        item.oldName = item.name
        listEleme.value.Edit('编辑 '+ item.name,item)
    } else listEleme.value.Edit('添加',item)
}

const fieldPage = (item)=>{
    router.push('/setting/table/field?table='+item.name);
}

const Backups = ()=>{
    ElMessageBox.confirm('确定备份数据库吗').then(()=>{
        Post('TableBackups').then(res=>{
            if(res.code==2000) ElMessage({message:res.msg,type:'success'});
        })
    }).catch(()=>{})
}
</script>