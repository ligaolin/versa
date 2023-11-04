<template>
    <list :getData="getData" :editPage="edit" ref="listEleme">
        <template #top>
            <div style="margin-top:20px;">所属自定义内容：{{ content_name }}</div>
        </template>
        <template #search>
            <label>ID：<el-input clearable v-model="id"/></label>
            <label>英文名称：<el-input clearable v-model="name"/></label>
            <label>中文名称：<el-input clearable v-model="cname"/></label>
            <label>字段类型：<el-input clearable v-model="type"/></label>
            <label>可否为空：
                <el-select v-model="is_null">
                    <el-option label="请选择" value=""/>
                    <el-option label="可以" :value="true" />
                    <el-option label="不可以" :value="false" />
                </el-select>
            </label>
            <label>可否为空：
                <el-select v-model="is_repeat">
                    <el-option label="请选择" value=""/>
                    <el-option label="可以" :value="true" />
                    <el-option label="不可以" :value="false" />
                </el-select>
            </label>
            <label>默认值：<el-input clearable v-model="defaultVal"/></label>
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
        <el-table-column prop="type" label="类型" align="center"/>
        <el-table-column prop="is_null" label="可否为空" align="center"/>
        <el-table-column prop="is_repeat" label="可否重复" align="center"/>
        <el-table-column prop="default" label="默认值" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button type="primary" size="small" @click="addEdit(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="Del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </list>

</template>

<script setup>
import edit from "./fieldedit.vue";
import { ref } from 'vue'
import { useRoute } from 'vue-router'
const route = useRoute()

const content_id = ref(route.query.id)
const content_name = ref(route.query.name)
const id = ref('')
const name = ref('')
const cname = ref('')
const type = ref('')
const is_null = ref('')
const is_repeat = ref('')
const defaultVal = ref('')
const state = ref('')

const getData = ()=>{
    let param = {content_id : content_id.value}
    if(content_id.value) param.content_id = content_id.value
    if(content_name.value) param.content_name = content_name.value
    if(id.value) param.id = id.value
    if(name.value) param.name = name.value
    if(cname.value) param.cname = cname.value
    if(type.value) param.type = type.value
    if(is_null.value!=='') param.is_null = is_null.value
    if(is_repeat.value!=='') param.is_repeat = is_repeat.value
    if(defaultVal.value) param.default = defaultVal.value
    if(state.value) param.state = state.value
    return ['ContentFieldList',param]
}

const listEleme = ref(null)
const Del = (ids)=>{
    listEleme.value.Del('ContentFieldDel',ids)
}
const addEdit = (item={}) => {
    item.content_id = content_id.value
    item.content_name = content_name.value
    if(item.id) {
        listEleme.value.Edit('编辑 '+ item.name,item)
    } else listEleme.value.Edit('添加',item)
}
</script>