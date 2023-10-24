<template>
    <table class="edit_table">
        <editTr label="数据表"> {{ data.table }} </editTr>
        <editTr label="字段名称">
            <el-input clearable v-model="data.name" size="large" />
        </editTr>
        <editTr label="字段类型">
            <el-input clearable v-model="data.type" size="large" />
        </editTr>
        <editTr label="可否为空">
            <el-radio-group v-model="data.isNull">
                <el-radio :label="true">可以</el-radio>
                <el-radio :label="false">不可以</el-radio>
            </el-radio-group>
        </editTr>
        <editTr label="默认值">
            <el-input clearable v-model="data.default" size="large" />
        </editTr>
        <editTr label="注释">
            <el-input clearable v-model="data.comment" size="large" />
        </editTr>
        <!-- <editTr label="键">
            <el-input clearable v-model="data.key" size="large" />
        </editTr> -->
       
        <editTr>
            <el-button type="primary" size="large" @click="submit">提交</el-button>
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
    table:'',
    oldName:'',
    name:'',
    type:'',
    isNull:true,
    default:'',
    comment:'',
    // key:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.table,'数据表名称不能为空'],
        [!data.value.name,'字段名称不能为空'],
        [!data.value.type,'字段类型不能为空'],
    ])) return

    let url = 'FieldAdd'
    if(data.value.oldName) url = 'FieldEdit'
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