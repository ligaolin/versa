<template>
    <table class="edit_table">
        <editTr label="数据表名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="数据表注释">
            <el-input clearable v-model="data.comment" />
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
    name:'',
    comment:'',
    oldName:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'数据表名称不能为空'],
    ])) return

    let url = 'TableAdd'
    if(data.value.oldName) url = 'TableEdit'
    Post(url,data.value).then(res=>{
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