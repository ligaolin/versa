<template>
<el-tabs v-model="activeName" addable type="card" @edit="handleTabsEdit">
    <el-tab-pane :name="item.type" v-for="item in list">
        <template #label>
            <div class="label">{{item.name}}</div>
            <template v-if="item.edit=='是'">
                <el-icon class="icon" @click.stop="addEdit('编辑 '+item.name,item)"><EditPen /></el-icon>
                <el-icon class="icon" @click.stop="del(item.id,item.type)"><Close /></el-icon>
            </template>
        </template>
    </el-tab-pane>
</el-tabs>

<el-dialog v-model="editShow" :title="editTitle" width="80%">
    <edit v-if="editShow" :data="editData" @submit="editSubmit" />
</el-dialog>
</template>

<script setup>
import { ref,watch } from 'vue'
import edit from "./tabsEdit.vue"
import { Post } from '@/api/api'
const emit = defineEmits(['active','success'])

const activeName = ref('site')
emit('active',activeName.value)
watch(activeName, (data) => {
    emit('active',data)
})

const list = ref([])
const getList = ()=>{
    Post('ConfigTypeList').then(res=>{
        if(res.code == 2000) list.value = res.data
        emit('success')
    })
}
getList()

const editBefore = ref('')
const editShow = ref(false)
const editTitle = ref('')
const editData = ref({})
const editSubmit = (item)=>{
    if(editBefore.value==activeName.value) {
        activeName.value = item.type 
        editBefore.value = ''
    }
    editShow.value=false
    getList()
}
// 编辑
const addEdit = (title='',data={}) => {
    editBefore.value = data.type
    editTitle.value = title
    editData.value = data
    editShow.value = true
}
// 添加
const handleTabsEdit = (a,b)=>{
    editTitle.value = '添加'
    editData.value = {}
    editShow.value = true
}

const del = (ids,type)=>{
    if(!ids) {ElMessage({message:'没有选中数据',type:'error'});return}
    editBefore.value = type
    ElMessageBox.confirm('确定删除吗，将同时删除该类型下的所有配置').then(()=>{
        Post('ConfigTypeDel',{id:ids}).then(res=>{
            if(res.code==2000){
                ElMessage({message:res.msg,type:'success'})
                if(editBefore.value==activeName.value) {
                    activeName.value = 'site'
                    editBefore.value = ''
                }
                getList()
            }else{
                ElMessage({message:res.msg,type:'error'})
            }
        })
    }).catch(()=>{})
}
</script>

<style scoped>
.is-active .label{color:#409eff;}
.label{color:#333}
.icon{margin-left:8px;color:#333;}
.icon:hover{color:#409eff;}
</style>