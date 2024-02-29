<template>
    <div>当前文件夹：{{ dir }}</div>
    <div class="tips">总数量：{{ total }}</div>
    <div class="tips">编辑或删除可能导致之前上传的文件丢失，操作前请确保被操作的文件或文件夹无需再被使用</div>
    <list :getData="getData" :editPage="addEditPage" ref="listEleme" rowKey="path" :page="false" @listEnd="listEnd">
        <template #search>
            <label>名称：<el-input clearable v-model="name"/></label>
        </template>

        <template #operation="{ ids }">
            <el-button type="primary" v-if="dir!='static'" @click="go()">返回上级</el-button>
            <el-upload :action="http+'/app/api/admin/other.Upload/Index?dir='+dir" :headers="headers" multiple :show-file-list="false" :on-change="uploadChange" class="upload">
                <el-button type="primary">上传文件</el-button>
            </el-upload>
            <el-button type="primary" @click="addEdit">添加文件夹</el-button>
            <el-button type="danger" @click="del(ids)">批量删除</el-button>
        </template>

        <el-table-column type="selection" width="55" align="center"/>
        <el-table-column prop="name" sortable label="名称" align="center"/>
        <el-table-column label="预览" align="center">
            <template #default="scope">
                <media :item="scope.row"></media>
            </template>
        </el-table-column>
        <el-table-column prop="fileOrDir" label="文件|文件夹" align="center" />
        <el-table-column prop="dir" sortable label="文件类型" align="center">
            <template #default="scope">
                {{ scope.row.type=='dir'?'-':scope.row.type }}
            </template>
        </el-table-column>

        <el-table-column label="操作" align="center" width="220">
            <template #default="scope">
                <el-button type="primary" size="small" v-if="scope.row.type=='dir'" @click="go(scope.row.path)">下级</el-button>
                <el-button type="primary" size="small" @click="addEdit(scope.row)">编辑</el-button>
                <el-button type="danger" size="small" @click="del(scope.row.path)">删除</el-button>
            </template>
        </el-table-column>
    </list>
</template>

<script setup>
import edit from "./edit.vue"
import add from "./add.vue"
import { ref,watch,markRaw } from 'vue'
import { useRouter,useRoute } from 'vue-router'
import { http } from '@/data'
import media from '@/components/media.vue'
const router = useRouter(),route = useRoute()

const name = ref("")
const dir = ref(route.query.dir||"static")
watch(()=>route.query.dir, (newData) => {
    if(!newData) dir.value = 'static'
    else dir.value = newData
    listEleme.value.Init()
}, { deep: true })

const getData = ()=>{
    let param = {dir:dir.value}
    if(name.value) param.name = name.value
    return ['FileList',param]
}

const total = ref(0)
const listEnd = res=>{
    if(res.code==2000) total.value = res.total
}

const listEleme = ref(null)
const del = (ids)=>{
    listEleme.value.Del('FileDel',ids,'path')
}
const addEditPage = ref()
const addEdit = (item={}) => {
    if(item.name) {
        addEditPage.value = markRaw(edit)
        listEleme.value.Edit('编辑 '+item.name,item)
    }else{
        addEditPage.value = markRaw(add)
        listEleme.value.Edit('添加文件夹',{path:dir.value})
    }
}
const go = (path)=>{
    if(!path) path = dir.value.replace(/\/[^\/]*$/, "");
    router.push('/setting/file/index?dir='+path);
}

const headers = ref({Authorization:localStorage.getItem('adminToken')})
const uploadChange = (file,files)=>{
    if(file.response && file.response.code){
        if(file.response.code==2000) listEleme.value.Init()
        else if(file.response.code==1000) ElMessage({message:file.response.msg,type:'error'})
    }
}
</script>
<style scoped>
.upload{display:inline-block;margin:0 10px;vertical-align:middle;}
.tips{color:#666;margin-top:10px;}
</style>