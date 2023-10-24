<template>
    <table class="edit_table">
        <editTr label="权限名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="路由">
            <el-input clearable v-model="data.route" />
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
    pid:0,
    level:1,
    name:'',
    route:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'权限名称不能为空'],
    ])) return

    Post('UserAuthAdminEdit',data.value).then(res=>{
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