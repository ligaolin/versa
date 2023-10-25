<template>
<table class="edit_table">
    <tr>
        <td>搜索</td>
        <td>
            <el-input clearable v-model="name" placeholder="名称" style="margin-right:10px;"/>
            <el-button @click="getList">搜索</el-button>
            <el-button type="primary" @click="addEdit()">添加</el-button>
        </td>
        <td>排序</td>
        <td>操作</td>
    </tr>
    <tr v-for="item in list">
        <td valign="top" class="title"> {{ item.name }} </td>
        <td>
            <el-input v-if="item.field_type=='单行文本'" clearable v-model="item.val" />

            <el-input v-else-if="item.field_type=='单行数字'" type="number" clearable v-model="item.val" />

            <el-input v-else-if="item.field_type=='多行文本'" type="textarea" style="width:300px;" clearable v-model="item.val" />

            <el-radio-group v-else-if="item.field_type=='单选项'" v-model="item.val">
                <el-radio :label="item1" border v-for="item1 in item.vals.split(',')">{{item1}}</el-radio>
            </el-radio-group>

            <el-select v-else-if="item.field_type=='下拉菜单'" v-model="item.val">
                <el-option label="请选择" value=""/>
                <el-option :label="item1" :value="item1" v-for="item1 in item.vals.split(',')"/>
            </el-select>
            
            <upload v-else-if="item.field_type=='上传图片'" :list="item.val" @change="res=>item.val=res" accept="image/*"/>
            <upload v-else-if="item.field_type=='上传视频'" :list="item.val" @change="res=>item.val=res" accept="video/*"/>
            <upload v-else-if="item.field_type=='上传文件'" :list="item.val" @change="res=>item.val=res" accept="*"/>

            <wangEditor v-else-if="item.field_type=='编辑器'" :val="item.val" @change="res=>item.val=res"/>

        </td>
        <td valign="top">
            <el-input clearable v-model="item.sort" @change="change('sort',item.sort,item.id)" style="width:100px;margin-top:5px;" />
        </td>
        <td class="operation" valign="top">
            <el-button type="primary" size="small" @click="addEdit('编辑 '+item.name,item)">编辑</el-button>
            <el-button type="danger" size="small" @click="del(item.id)">删除</el-button>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><el-button type="primary" @click="submit">提交</el-button></td>
        <td></td>
        <td></td>
    </tr>
</table>

<el-dialog v-model="editShow" :title="editTitle" width="80%">
    <edit v-if="editShow" :data="editData" @submit="editSubmit" />
</el-dialog>

</template>
<script setup>
import edit from "./edit.vue"
import { ref } from 'vue'
import { Post } from '@/api/api'

const submit = ()=>{
    Post('ConfigForEditVal',{data:list.value}).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            getList()
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}

const name = ref("")
const list = ref([])
const getList = ()=>{
    let param = {type:'site'}
    if(name.value) param.name = name.value
    Post('ConfigListAuth',param).then(res=>{
        if(res.code == 2000) list.value = res.data
    })
}
getList()

const editShow = ref(false)
const editTitle = ref('')
const editData = ref({})
const editSubmit = ()=>{
    editShow.value=false
    getList()
}
const addEdit = (title='添加',data={}) => {
    data.type = 'site'
    editTitle.value = title
    editData.value = data
    editShow.value = true
}

const change = (changeField,changeVal,whereVal)=>{
    if(!whereVal) {ElMessage({message:'缺少条件值',type:'error'});return}
    if(!changeField) {ElMessage({message:'缺少改变字段',type:'error'});return}
    if(!changeVal) {ElMessage({message:'缺少改变值',type:'error'});return}
    Post('ConfigChange',{
        whereField:'id',
        whereVal:whereVal,
        changeField:changeField,
        changeVal:changeVal,
    }).then(res=>{
        if(res.code==2000){
            ElMessage({message:res.msg,type:'success'})
            getList()
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}

const del = (ids)=>{
    if(!ids) {ElMessage({message:'没有选中数据',type:'error'});return}
    ElMessageBox.confirm('确定删除指定数据吗').then(()=>{
        Post('ConfigDel',{id:ids}).then(res=>{
            if(res.code==2000){
                ElMessage({message:res.msg,type:'success'})
                getList()
            }else{
                ElMessage({message:res.msg,type:'error'})
            }
        })
    }).catch(()=>{})
}
</script>

<style scoped>
.edit_table tr:first-child td{border-bottom:solid 1px #e9e9e9;}

.title{padding-top: 18px;display:flex;align-items:center;justify-content: flex-end;}
.operation{min-width:160px;padding-top: 18px;}
.operation .el-icon{margin-left:6px;cursor:pointer;}
</style>