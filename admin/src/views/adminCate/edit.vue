<template>
    <table class="edit_table">
        <tr>
            <td>栏目名称</td>
            <td><el-input v-model="data.name" size="large" /></td>
        </tr>
        <tr>
            <td>栏目类型</td>
            <td>
                <el-radio-group v-model="data.type">
                    <el-radio label="分类" border>分类</el-radio>
                    <el-radio label="页面" border>页面</el-radio>
                </el-radio-group>
            </td>
        </tr>
        <template v-if="data.type=='页面'">
            <tr>
                <td>栏目跳转路径</td>
                <td><el-input v-model="data.path" size="large" /></td>
            </tr>
            <tr>
                <td>栏目文件路径</td>
                <td><el-input v-model="data.view" size="large" /></td>
            </tr>
        </template>
        <tr v-if="data.level==1">
            <td>栏目图标</td>
            <td>
                <el-input v-model="data.icon" size="large" />
                <div class="tips">
                    <a href="https://element-plus.gitee.io/zh-CN/component/icon.html" target="_blank">查看可选图标</a>，示例，复制值：&lt;el-icon&gt;&lt;Notification /&gt;&lt;/el-icon&gt;，填写值：Notification
                </div>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><el-button type="primary" size="large" @click="submit">提交</el-button></td>
        </tr>
    </table>
</template>
<script setup>
import { ref } from 'vue'
import { editAdminCate } from '@/api/setting/AdminCate'
const props = defineProps(['data'])
const emit = defineEmits(['submit'])

const data = ref({
    id:'',
    pid:0,
    level:1,
    name:'',
    type:'分类',
    path:'',
    view:'',
    icon:'',
})
for(let i in data.value){
    for(let j in props.data){
        if(i==j) data.value[i] = props.data[j]
    }
}

const submit = ()=>{
    if(!data.value.name) {ElMessage({message:"栏目名称不能为空",type:'error'});return;}
    if(!data.value.type) {ElMessage({message:"请选择栏目类型",type:'error'});return;}
    if(data.value.type == "页面") {
        if(!data.value.path) {ElMessage({message:"栏目跳转路径不能为空",type:'error'});return;}
        if(!data.value.view) {ElMessage({message:"栏目文件路径不能为空",type:'error'});return;}
    }
    if(data.value.level==1 && !data.value.icon) {ElMessage({message:"请填写图标",type:'error'});return;}
    editAdminCate(data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit')
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}
</script>

<style scoped>
</style>