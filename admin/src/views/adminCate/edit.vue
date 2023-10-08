<template>
    <table class="edit_table">
        <tr>
            <td>栏目名称</td>
            <td><el-input v-model="name" size="large" /></td>
        </tr>
        <tr>
            <td>栏目类型</td>
            <td>
                <el-radio-group v-model="type">
                    <el-radio label="分类" border>分类</el-radio>
                    <el-radio label="页面" border>页面</el-radio>
                </el-radio-group>
            </td>
        </tr>
        <tr v-if="type=='页面'">
            <td>栏目跳转路径</td>
            <td><el-input v-model="path" size="large" /></td>
        </tr>
        <tr v-if="type=='页面'">
            <td>栏目文件路径</td>
            <td><el-input v-model="view" size="large" /></td>
        </tr>
        <tr v-if="level==1">
            <td>栏目图标</td>
            <td>
                <el-input v-model="icon" size="large" />
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
import { getAdminCateById,editAdminCate } from '@/api/setting'
const props = defineProps(['id','pid','level'])
const emit = defineEmits(['submit'])

const name = ref("")
const type = ref("分类")
const path = ref("")
const view = ref("")
const icon = ref("")

if(props.id){
    getAdminCateById({id:props.id}).then(res=>{
        if(res.code == 2000){
            name.value = res.data.Name
            type.value = res.data.Type
            path.value = res.data.Path
            view.value = res.data.View
            icon.value = res.data.Icon
        }
    })
}

const submit = ()=>{
    if(!name.value) {ElMessage({message:"栏目名称不能为空",type:'error'});return;}
    if(!type.value) {ElMessage({message:"请选择栏目类型",type:'error'});return;}
    if(type.value == "页面") {
        if(!path.value) {ElMessage({message:"栏目跳转路径不能为空",type:'error'});return;}
        if(!view.value) {ElMessage({message:"栏目文件路径不能为空",type:'error'});return;}
    }
    if(props.level==1 && !icon.value) {ElMessage({message:"请填写图标",type:'error'});return;}
    editAdminCate({
        id:props.id,
        pid:props.pid,
        level:props.level,
        name:name.value,
        type:type.value,
        path:path.value,
        view:view.value,
        icon:icon.value,
    }).then(res=>{
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