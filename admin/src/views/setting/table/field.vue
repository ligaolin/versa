<template>
    <list :getData="getData" :editPage="edit" ref="listEleme" rowKey="name" :page="false">
        <template #top>
            <div style="margin-top:20px;">数据表：{{ table }}</div>
        </template>

        <template #search>
            <label>字段名称：<el-input v-model="name"/></label>
            <label>字段类型：<el-input v-model="type"/></label>
            <label>可否为空：
                <el-select v-model="isNull" size="large">
                    <el-option label="请选择" value=""/>
                    <el-option label="可以" :value="true" />
                    <el-option label="不可以" :value="false" />
                </el-select>
            </label>
            <label>默认值：<el-input v-model="defaultVal"/></label>
            <label>注释：<el-input v-model="comment"/></label>
            <!-- <label>键：<el-input v-model="key"/></label> -->
        </template>

        <template #operation="{ ids }">
            <el-button type="primary" @click="addEdit()">添加</el-button>
            <el-button type="danger" @click="Del(ids)">批量删除</el-button>
        </template>

        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="name" label="字段名称" align="center"/>
        <el-table-column prop="type" label="类型" align="center"/>
        <el-table-column prop="isNull" label="可否为空" align="center">
            <template #default="scope">{{ scope.row.isNull?'可以':'不可以' }}</template>
        </el-table-column>
        <el-table-column prop="default" label="默认值" align="center"/>
        <!-- <el-table-column prop="key" label="键" align="center"/> -->
        <el-table-column prop="comment" label="注释" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button v-if="scope.row.name!='id'" type="primary" size="small" @click="addEdit(scope.row)">编辑</el-button>
                <el-button v-if="scope.row.name!='id'" type="danger" size="small" @click="Del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </list>

</template>

<script setup>
import edit from "./fieldedit.vue";
import { ref } from 'vue'
import { useRoute } from 'vue-router'
const route = useRoute()

const table = ref(route.query.table)
const name = ref('')
const type = ref('')
const isNull = ref('')
const defaultVal = ref('')
const comment = ref('')
// const key = ref('')

const getData = ()=>{
    let param = {table : table.value}
    if(name.value) param.name = name.value
    if(type.value) param.type = type.value
    if(isNull.value!=='') param.isNull = isNull.value
    if(defaultVal.value) param.default = defaultVal.value
    if(comment.value) param.comment = comment.value
    // if(key.value) param.key = key.value
    return ['FieldList',param]
}

const listEleme = ref(null)
const Del = (ids)=>{
    listEleme.value.Del('FieldDel',ids,'name')
}
const addEdit = (item={}) => {
    item.table = table.value
    if(item.name) {
        item.oldName = item.name
        listEleme.value.Edit('编辑 '+ item.name,item)
    } else listEleme.value.Edit('添加',item)
}
</script>