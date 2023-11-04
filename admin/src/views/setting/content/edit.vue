<template>
    <table class="edit_table">
        <editTr label="英文名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="中文名称">
            <el-input clearable v-model="data.cname" />
        </editTr>
        <editTr label="选择所属栏目" required>
            <el-select v-model="data.cate_pid">
                <el-option label="请选择" value=""/>
                <cateOption :list="cateList" />
            </el-select>
        </editTr>
        <editTr label="栏目图标">
            <el-input clearable v-model="data.icon" />
            <div class="tips">
                <div>为首级栏目时填写</div>
                <a href="https://element-plus.gitee.io/zh-CN/component/icon.html" target="_blank">查看可选图标</a>，示例：复制值“&lt;el-icon&gt;&lt;Notification /&gt;&lt;/el-icon&gt;”，填写值“Notification”
            </div>
        </editTr>
       
        <editTr>
            <el-button type="primary" @click="submit">提交</el-button>
        </editTr>
    </table>
</template>
<script setup>
import { ref } from 'vue'
import { Post } from '@/api/api'
import { ObjSetObj,Error } from '@/utils/other'
import cateOption from './cateOption.vue'
const props = defineProps(['data'])
const emit = defineEmits(['submit'])

const data = ref({
    id:'',
    name:'',
    cname:'',
    cate_pid:'',
    cate_id:'',
    icon:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'英文名称必须'],
        [!data.value.cate_pid,'所属栏目必须'],
    ])) return

    Post('ContentEdit',data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit')
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}

const cateList = ref([])
Post('AdminCateGetListByPid').then(res=>{
    if(res.code==2000) cateList.value = res.data
})
</script>

<style scoped>
</style>