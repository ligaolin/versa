<template>
    <table class="edit_table">
        <editTr label="组名称">
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="权限">
            <el-tree
                ref="treeRef"
                :data="auths"
                show-checkbox
                node-key="id"
                default-expand-all
                :expand-on-click-node="false"
                :props="{label:'name',class:customNodeClass}"
                :default-checked-keys="checkedKeys"
            />
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

const customNodeClass = (data, node)=>{
    if(data.level==2) return 'flex';
    return null;
}

const data = ref({
    id:'',
    name:'',
    auth_ids:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    data.value.auth_ids = ','+treeRef.value.getCheckedKeys().join(',')

    if(!Error([
        [!data.value.name,'组名称不能为空'],
    ])) return

    Post('UserGroupAdminEdit',data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit')
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}

const auths = ref([])
const treeRef = ref()
const checkedKeys = ref(props.data.auth_ids?props.data.auth_ids.slice(1).split(','):[])
const getAuth = ()=>{
    Post('UserAuthGetListByPid',{pid:0,state:'开启'}).then(res=>{
        if(res.code == 2000){
            auths.value = res.data
        }
    })
}
getAuth()
</script>

<style scoped>
:deep .flex > .el-tree-node__children { display: flex; }
</style>