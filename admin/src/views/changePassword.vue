<template>
    <table class="edit_table">
        <editTr label="原密码" required>
            <el-input clearable v-model="data.originalPassword" />
        </editTr>
        <editTr label="密码" required>
            <el-input clearable v-model="data.password" />
            <div class="tips" v-if="data.id">不修改密码不用填写</div>
        </editTr>
        <editTr label="重复密码" required>
            <el-input clearable v-model="data.duplicatePassword" />
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
const emit = defineEmits(['submit'])

const data = ref({
    originalPassword:'',
    password:'',
    duplicatePassword:'',
})

const submit = ()=>{
    if(!Error([
        [!data.value.originalPassword,'原密码必须'],
        [!data.value.password,'密码必须'],
        [!data.value.duplicatePassword,'重复密码不能为空'],
    ])) return
    Post('UseradminChangePassword',data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit')
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}
</script>