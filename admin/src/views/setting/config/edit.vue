<template>
    <table class="edit_table">
        <editTr label="名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="值" v-if="data.field_type!='上传文件'">
            <el-input clearable v-model="data.val" type="textarea" style="width:300px;"/>
        </editTr>
        <!-- <editTr label="分类">
            <el-input clearable v-model="data.type" />
        </editTr> -->
        <editTr label="数据类型">
            <el-select v-model="data.field_type">
                <el-option label="单行文本" value="单行文本"/>
                <el-option label="单行数字" value="单行数字"/>
                <el-option label="多行文本" value="多行文本"/>
                <el-option label="单选项" value="单选项"/>
                <el-option label="多选项" value="多选项"/>
                <el-option label="下拉菜单" value="下拉菜单"/>
                <el-option label="上传图片" value="上传图片"/>
                <el-option label="上传视频" value="上传视频"/>
                <el-option label="上传文件" value="上传文件"/>
                <el-option label="编辑器" value="编辑器"/>
            </el-select>
        </editTr>
        <editTr label="可选值" required v-if="data.field_type=='单选项' || data.field_type=='多选项' || data.field_type=='下拉菜单'">
            <el-input clearable v-model="data.vals" />
            <div class="tips">多个可选值之间用“,”隔开，示例：1,2,3</div>
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
const props = defineProps(['data'])
const emit = defineEmits(['submit'])

const data = ref({
    id:'',
    name:'',
    val:'',
    type:'site',
    field_type:'单行文本',
    vals: '',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'名称不能为空'],
        [((data.value.field_type=='单选项' || data.value.field_type=='多选项' || data.value.field_type=='下拉菜单') && !data.value.vals),'当前类型可选值必须'],
    ])) return

    Post('ConfigEdit',data.value).then(res=>{
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