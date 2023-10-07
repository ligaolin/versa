<template>
    <div class="searchBar">
        <label>栏目名称：<el-input v-model="name"/></label>
        <el-button @click="getData">搜索</el-button>
        <el-button type="primary" @click="editShow">添加</el-button>
        <el-button type="danger" @click="del(id_arr)">批量删除</el-button>
    </div>
    <el-table class="listTable" border :data="tableData" @selection-change="selRow" row-key="ID" lazy
      :load="load">
        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="ID" label="ID" />
        <el-table-column prop="Name" label="栏目名称" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button type="primary" size="small" @click="addPage(scope.row)">添加下级</el-button>
                <el-button type="primary" size="small" @click="editPage(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="del(scope.row.ID)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>

    <el-pagination v-model:current-page="page" v-model:page-size="page_size" :page-sizes="[10, 15, 20, 50]" layout="total, sizes, prev, pager, next, jumper" :total="total" @size-change="sizeChange" @current-change="currentChange"/>

    <el-dialog v-model="edit_show" :title="edit_title" width="80%">
      <edit v-if="edit_show" :id="id" :pid="pid" :level="level" @submit="submit"></edit>
    </el-dialog>
</template>

<script setup>
import edit from './edit.vue'
import { ref } from 'vue'
import { adminCate,delAdminCate,addTable } from '@/api/setting'
addTable()
let name = ref("")

let tableData = ref([])
let page = ref(1)
let page_size = ref(5)
let total = ref(0)
let id_arr = ref('')

let edit_show = ref(false)
let edit_title = ref("添加")
let id = ref(0)
let pid = ref(0)
let level = ref(1)
let editShow = ()=>{
    edit_show.value = true
}

const submit = ()=>{
    edit_show=false
    setTimeout(()=>{location.reload()},1200)
}

const del = (id)=>{
    if(!id) {ElMessage({message:'没有选中数据',type:'error'});return}
    ElMessageBox.confirm('确定删除指定数据吗').then(()=>{
        delAdminCate({id:id}).then(res=>{
            if(res.code==2000){
                ElMessage({message:res.msg,type:'success'})
                setTimeout(()=>{location.reload()},1200)
            }else{
                ElMessage({message:res.msg,type:'error'})
            }
        })
    }).catch(()=>{})
}

const getData = ()=>{
    let param = {
        page:page.value,
        page_size:page_size.value,
        pid:0,
    }
    if(name.value) param.name = name.value
    adminCate(param).then(res=>{
        if(res.code==2000){
            tableData.value =  res.data
            total.value = res.total
        }
    })
}
getData()

const load = (data,treeNode,resolve)=>{
    adminCate({pid:data.ID}).then(res=>{
        if(res.code == 2000) resolve(res.data);
    })
}

const addPage = item => {
    edit_title.value = '添加 '+ item.Name + ' 下级'
    id.value = 0
    pid.value = item.ID
    level.value = ++item.Level
    edit_show.value = true
}

const editPage = item => {
    edit_title.value = '编辑 '+item.Name
    id.value = item.ID
    pid.value = item.Pid
    level.value = item.Level
    edit_show.value = true
}

const currentChange = val => {
    page.value = val
    getData()
}

const sizeChange = val =>{
    page_size.value = val
    getData()
}

const selRow = val => {
    id_arr = ''
    for(let i in val){
        if(!parseInt(i)) {id_arr = val[i].ID}
        else {id_arr += ','+val[i].ID}
    }
}
</script>

<style scoped>
</style>