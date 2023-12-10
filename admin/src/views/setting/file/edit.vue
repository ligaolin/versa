<template>
    <table class="edit_table">
        <editTr label="原名称">
            {{name}}
        </editTr>
        <editTr label="新名称" required>
            <el-input clearable v-model="data.newName" />
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
    path:'',
    name:'',
    newName:'',
    extension:'',
})
ObjSetObj(props.data,data.value)
const name = ref('')
name.value = data.value.name.substring(0, data.value.name.lastIndexOf("."));

const submit = ()=>{
    if(!Error([
        [!data.value.newName,'新名称不能为空'],
    ])) return
    let param = data.value;
    param.newName += param.extension?'.'+param.extension:''
    Post('FileChange',data.value).then(res=>{
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