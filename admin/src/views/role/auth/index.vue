<template>
    <list :getData="getData" :editPage="edit" ref="listEleme" @editEnd="editEnd">
        <template #search>
            <label>栏目名称：<el-input v-model="name"/></label>
        </template>

        <template #operation="{ ids }">
            <el-button type="primary" @click="addEdit()">添加</el-button>
            <el-button type="danger" @click="Del(ids)">批量删除</el-button>
        </template>

        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="栏目名称" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button type="primary" size="small" @click="addEdit(scope.row)">添加下级</el-button>
                <el-button type="primary" size="small" @click="addEdit(scope.row,true)">编辑</el-button>
                <el-button type="danger" size="small" @click="Del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </list>

</template>

<script setup>
import edit from "./edit.vue"
import { ref } from 'vue'
const name = ref("")
const getData = ()=>{
    let param = {pid : 0}
    if(name.value) param.name = name.value
    return ['AdminCateList',param]
}

const listEleme = ref(null)
const Del = (ids)=>{
    listEleme.value.Del('AdminCateDel',ids)
}
const addEdit = (item={},isEdit=false) => {
    if(!isEdit){
        if(item.id) listEleme.value.Edit('添加 '+ item.name + ' 的下级',{ pid:item.id, level:++item.level, })
        else listEleme.value.Edit('添加',{ pid:0, level:1, })
    } else listEleme.value.Edit('编辑 '+item.name,item)
}

const editEnd = ()=>{
    setTimeout(()=>{
        location.reload()
    },700)
}
</script>