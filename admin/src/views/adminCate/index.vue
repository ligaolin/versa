<template>
    <div class="searchBar">
        <label>栏目名称：<el-input v-model="name"/></label>
        <el-button @click="getData">搜索</el-button>
        <el-button type="primary" @click="addPage">添加</el-button>
        <el-button type="danger" @click="del(id_arr)">批量删除</el-button>
    </div>
    <el-table class="listTable" border :data="tableData" @selection-change="selRow" row-key="id" lazy :load="load">
        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="id" label="ID" />
        <el-table-column prop="name" label="栏目名称" align="center"/>
        <el-table-column label="操作" align="center">
            <template #default="scope">
                <el-button type="primary" size="small" @click="addPage(scope.row)">添加下级</el-button>
                <el-button type="primary" size="small" @click="editPage(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </el-table>

    <el-pagination v-model:current-page="page" v-model:page-size="page_size" :page-sizes="[10, 15, 20, 50]" layout="total, sizes, prev, pager, next, jumper" :total="total" @size-change="sizeChange" @current-change="currentChange"/>

    <el-dialog v-model="editShow" :title="editTitle" width="80%">
      <edit v-if="editShow" :data="editData" @submit="submit"></edit>
    </el-dialog>
</template>

<script setup>
import edit from "./edit.vue"
import { ref } from 'vue'
import { adminCate,delAdminCate } from '@/api/setting/AdminCate'
const name = ref("")

const tableData = ref([])
const page = ref(1)
const page_size = ref(5)
const total = ref(0)
const id_arr = ref('')

const editShow = ref(false)
const editTitle = ref("添加")
const editData = ref({})

const submit = ()=>{
    editShow.value=false
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
    adminCate({pid:data.id}).then(res=>{
        if(res.code == 2000) resolve(res.data);
    })
}

const addPage = (item={}) => {
    if(item.id){
        editTitle.value = '添加 '+ item.name + ' 的下级'
        editData.value.pid = item.id
        editData.value.level = ++item.level
    }else{
        editTitle.value = '添加'
        editData.value.pid = 0
        editData.value.level = 1
    }
    editShow.value = true
}

const editPage = item => {
    editTitle.value = '编辑 '+item.name
    editData.value = item
    editShow.value = true
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
        if(!parseInt(i)) {id_arr = val[i].id}
        else {id_arr += ','+val[i].id}
    }
}
</script>

<style scoped>
</style>