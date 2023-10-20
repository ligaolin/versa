<template>
    <table class="edit_table">
        <editTr label="栏目名称">
            <el-input v-model="data.name" size="large" />
        </editTr>
        <editTr label="栏目类型">
            <el-radio-group v-model="data.type">
                <el-radio label="分类" border>分类</el-radio>
                <el-radio label="页面" border>页面</el-radio>
            </el-radio-group>
        </editTr>

        <template v-if="data.type=='页面'">
            <editTr label="栏目跳转路径">
                <el-input v-model="data.path" size="large" />
            </editTr>
            <editTr label="栏目文件路径">
                <el-input v-model="data.view" size="large" />
            </editTr>
        </template>
        <editTr label="栏目图标" v-if="data.level==1" tip="">
            <el-input v-model="data.icon" size="large" />
            <div class="tips">
                <a href="https://element-plus.gitee.io/zh-CN/component/icon.html" target="_blank">查看可选图标</a>，示例：复制值“&lt;el-icon&gt;&lt;Notification /&gt;&lt;/el-icon&gt;”，填写值“Notification”
            </div>
        </editTr>
        <editTr>
            <el-button type="primary" size="large" @click="submit">提交</el-button>
        </editTr>
    </table>
</template>
<script setup>
import { ref } from 'vue'
import { editAdminCate } from '@/api/setting/AdminCate'
import { objSetObj,Error,Submit } from '@/utils/data.js'
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
objSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'栏目名称不能为空'],
        [!data.value.type,'请选择栏目类型'],
        [(data.value.type == "页面" && !data.value.path),'栏目跳转路径不能为空'],
        [(data.value.type == "页面" && !data.value.view),'栏目文件路径不能为空'],
        [(data.value.level==1 && !data.value.icon),'请填写图标'],
    ])) return
    Submit(editAdminCate,data.value,emit,'submit')
}
</script>

<style scoped>
</style>