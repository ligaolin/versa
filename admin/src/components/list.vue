<template>

<slot name="top"></slot>

<div class="searchBar">
    <slot name="search"></slot>
    <el-button @click="getData" v-if="searchShow">搜索</el-button>
    <slot name="operation" :ids="ids"></slot>
</div>

<el-table class="listTable" border :data="tableData" @selection-change="selRow" :row-key="rowKey" lazy :load="load">
    <slot></slot>
</el-table>

<el-pagination v-if="props.page" v-model:current-page="page" v-model:page-size="page_size" :page-sizes="[10, 15, 20, 50]" layout="total, sizes, prev, pager, next, jumper" :total="total" @size-change="sizeChange" @current-change="currentChange"/>

<el-dialog v-model="editShow" :title="editTitle" width="80%">
    <component :is="props.editPage" v-if="editShow" :data="editData" @submit="submit" />
</el-dialog>
</template>

<script setup>
import { ref,useSlots } from 'vue'
import { Post } from '@/api/api'
const searchShow = !!useSlots().search

const props = defineProps({
    getData:{ type: Function, default: [] },
    editPage:{ type: Object, default: {} },
    page:{ type: Boolean, default: true },
    rowKey:{ type: String, default: 'id' },
})
const emit = defineEmits(['editEnd'])

const tableData = ref([])
const page = ref(1)
const page_size = ref(5)
const total = ref(0)
const ids = ref([])

const getData = ()=>{
    tableData.value = []
    let [api,param] = props.getData()
    param.page = page.value
    param.page_size = page_size.value
    Post(api,param).then(res=>{
        if(res.code==2000){
            tableData.value =  res.data
            total.value = res.total
        }
    })
}
getData()
const init = ()=>{
    page.value = 1
    getData()
    emit('editEnd')
}

const currentChange = val => {
    page.value = val
    getData()
}

const sizeChange = val =>{
    page_size.value = val
    getData()
}

const load = (data,treeNode,resolve)=>{
    let [api,param,pid] = props.getData()
    if(pid) param[pid] = data.id
    else param.pid = data.id
    Post(api,param).then(res=>{
        if(res.code == 2000) resolve(res.data);
    })
}

const selRow = val => {
    for(let i in val){
        if(!parseInt(i)) {ids.value = val[i][props.rowKey]}
        else {ids.value += ','+val[i][props.rowKey]}
    }
}

const editShow = ref(false)
const editTitle = ref("添加")
const editData = ref({})
const submit = ()=>{
    editShow.value=false
    init()
}

const Edit = (title='添加',data={})=>{
    editTitle.value = title
    editData.value = data
    editShow.value = true
}

const Del = (api,ids,field='id')=>{
    if(!ids) {ElMessage({message:'没有选中数据',type:'error'});return}
    ElMessageBox.confirm('确定删除指定数据吗').then(()=>{
        let param = {}
        param[field] = ids
        Post(api,param).then(res=>{
            if(res.code==2000){
                ElMessage({message:res.msg,type:'success'})
                init()
            }else{
                ElMessage({message:res.msg,type:'error'})
            }
        })
    }).catch(()=>{})
}

defineExpose({Edit,Del})
</script>