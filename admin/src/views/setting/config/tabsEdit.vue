<template>
    <table class="edit_table">
        <editTr label="类型名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="类型值" required>
            <el-input clearable v-model="data.type" />
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
    type:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'类型名称不能为空'],
        [!data.value.type,'类型值不能为空'],
    ])) return

    Post('ConfigTypeEdit',data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit',data.value)
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}
</script>

<style scoped>
</style>