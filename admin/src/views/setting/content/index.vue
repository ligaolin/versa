<template>
    <list :getData="getData" :editPage="edit" ref="listEleme" :reload="true">
        <template #search>
            <label>ID：<el-input clearable v-model="id" type="number"/></label>
            <label>英文名称：<el-input clearable v-model="name"/></label>
            <label>中文名称：<el-input clearable v-model="cname"/></label>
            <label>后台栏目ID：<el-input clearable v-model="cate_id"/></label>
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
            <el-button type="danger" @click="Del(ids)">批量删除</el-button>
        </template>

        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="name" label="英文名称" align="center"/>
        <el-table-column prop="cname" label="中文名称" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button type="primary" size="small" @click="fieldPage(scope.row)">内容字段</el-button>
                <el-button type="primary" size="small" @click="addEdit(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="Del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </list>

</template>

<script setup>
import edit from "./edit.vue"
import { ref } from 'vue'
import { useRouter } from 'vue-router'
const router = useRouter()

const id = ref("")
const name = ref("")
const cname = ref("")
const cate_id = ref("")
const state = ref("")
const getData = ()=>{
    let param = {}
    if(id.value) param.id = id.value
    if(name.value) param.name = name.value
    if(cname.value) param.cname = cname.value
    if(cate_id.value) param.cate_id = cate_id.value
    if(state.value) param.state = state.value
    return ['ContentList',param]
}

const listEleme = ref(null)
const Del = (ids)=>{
    listEleme.value.Del('ContentDel',ids)
}

const addEdit = (item={}) => {
    if(item.name) {
        listEleme.value.Edit('编辑 '+ item.name,item)
    } else listEleme.value.Edit('添加',item)
}

const fieldPage = (item)=>{
    router.push('/setting/content/field?id='+item.id+'&name='+item.name);
}
</script>