<template>
    <table class="edit_table">
        <editTr label="管理员名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="所属管理员组" required>
            <el-select v-model="data.user_group_id">
                <el-option label="请选择" value=""/>
                <el-option :label="item.name" :value="item.id" v-for="item in groups"/>
            </el-select>
        </editTr>
        <editTr label="密码" required v-if="!data.id">
            <el-input clearable v-model="data.password" />
            <div class="tips" v-if="data.id">不修改密码不用填写</div>
        </editTr>
        <template v-if="data.password">
            <editTr label="重复密码" required>
                <el-input clearable v-model="data.duplicatePassword" />
            </editTr>
        </template>
        <editTr label="头像">
            <upload :list="data.avatar" @change="uploadChange"/>
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
    user_group_id:'',
    password:'',
    duplicatePassword:'',
    avatar: [],
})
for(let i in props.data){
    if(i=='avatar' && (typeof props.data[i] != 'array' && typeof props.data[i] != 'object')) {
        props.data[i] = []
    }
}
ObjSetObj(props.data,data.value)
data.value.password = ''
data.value.duplicatePassword = ''

const submit = ()=>{
    if(!Error([
        [!data.value.name,'管理员名称不能为空'],
        [!data.value.user_group_id,'请选择所属管理员组'],
        [(!data.value.id && !data.value.password),'密码必须'],
        [(data.value.password && !data.value.duplicatePassword),'重复密码不能为空'],
    ])) return

    Post('UserAdminEdit',data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit')
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}
const uploadChange = (res)=>{
    data.value.avatar = res
}

const groups = ref([])
Post('UserGroupList',{type:'管理员',state:'开启'}).then(res=>{
    if(res.code == 2000) groups.value = res.data
})
</script>

<style scoped>
</style>