<template>
    <list :getData="getData" :editPage="edit" ref="listEleme" >
        <template #search>
            <label>ID：<el-input clearable v-model="id"/></label>
            <label>管理员名称：<el-input clearable v-model="name"/></label>
            <label>所属管理员组：<el-input clearable v-model="group_name"/></label>
            <label>状态：
                <el-select v-model="state">
                    <el-option label="请选择" value=""/>
                    <el-option label="开启" value="开启" />
                    <el-option label="关闭" value="关闭" />
                </el-select>
            </label>
        </template>

        <template #operation="{ ids }">
            <el-button type="primary" @click="addEdit()">添加</el-button>
            <el-button type="danger" @click="del(ids)">批量删除</el-button>
        </template>

        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="管理员名称" align="center"/>
        <el-table-column prop="group_name" label="所属管理员组" align="center"/>
        <el-table-column label="排序" align="center">
            <template #default="scope">
                <el-input clearable v-model="scope.row.sort" @change="change('sort',scope.row.sort,scope.row.id)" />
            </template>
        </el-table-column>
        <el-table-column label="状态" align="center">
            <template #default="scope">
                <el-switch v-model="scope.row.state" active-value="开启" inactive-value="关闭" active-text="开启" inactive-text="关闭" inline-prompt @change="change('state',scope.row.state,scope.row.id)"/>
            </template>
        </el-table-column>
        <el-table-column label="操作" align="center" width="220">
            <template #default="scope">
                <el-button type="primary" size="small" @click="addEdit(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </list>

</template>

<script setup>
import edit from "./edit.vue"
import { ref } from 'vue'
const id = ref("")
const name = ref("")
const group_name = ref("")
const state = ref("")
const getData = ()=>{
    let param = {pid : 0,type:'管理员'}
    if(id.value) param.id = id.value
    if(name.value) param.name = name.value
    if(group_name.value) param.group_name = group_name.value
    if(state.value) param.state = state.value
    return ['UserList',param]
}

const listEleme = ref(null)
const del = (ids)=>{
    listEleme.value.Del('UserAdminDel',ids)
}
const addEdit = (item={},isEdit=false) => {
    if(item.id) listEleme.value.Edit('编辑 '+item.name,item)
    else listEleme.value.Edit('添加',item)
}
const change = (changeField,changeVal,whereVal)=>{
    listEleme.value.Change('UserGroupAdminChange',changeField,changeVal,whereVal)
}
</script>