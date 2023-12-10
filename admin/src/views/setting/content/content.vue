<template>
<list :getData="getData" ref="listEleme">
    <template #search>

    </template>

    <template #operation="{ ids }">
        <el-button type="primary" @click="addEdit()">添加</el-button>
        <el-button type="danger" @click="del(ids)">批量删除</el-button>
    </template>

    <template v-for="item in listField">
        <el-table-column v-if="item.type=='text'" :prop="item.field" :label="item.name" align="center"/>
        <el-table-column v-else-if="item.type=='input'" :label="item.name" align="center">
            <template #default="scope">
                <el-input clearable v-model="scope.row[item.field]" @change="change(item.field,scope.row[item.field],scope.row.id)" />
            </template>
        </el-table-column>
        <el-table-column v-else-if="item.type=='switch'" :label="item.name" align="center">
            <template #default="scope">
                <el-switch v-if="item.vals&&item.vals.length>=2" v-model="scope.row[item.field]" :active-value="item.vals[0]" :inactive-value="item.vals[1]" :active-text="item.vals[0]" :inactive-text="item.vals[1]" inline-prompt @change="change([item.field],scope.row[item.field],scope.row.id)"/>
            </template>
        </el-table-column>

        <el-table-column v-else-if="item.type=='oper'" :label="item.name" align="center" width="220">
            <template #default="scope">
                <el-button type="primary" size="small" v-if="item.oper.indexOf('添加下级') != -1 && (!scope.row.level || !item.oper.split('|').pop() || scope.row.level<item.oper.split('|').pop())" @click="addEdit(scope.row)">添加下级</el-button>
                <el-button type="primary" size="small" v-if="item.oper.indexOf('编辑') != -1" @click="addEdit(scope.row,true)">编辑</el-button>
                <el-button type="danger" size="small" v-if="item.oper.indexOf('删除') != -1" @click="del(scope.row.id)">删除</el-button>
            </template>
        </el-table-column>
    </template>
   
</list>
</template>

<script setup>
import { ref } from 'vue'
import { Post } from '@/api/api'
import { useRoute } from 'vue-router'
const route = useRoute()

const content_id = ref(route.query.id)

const search = ref([])
const listField = ref([])
if(content_id.value){
    Post('ContentGet',{id:content_id.value}).then(res=>{
        if(res.code==2000){
            
            if(res.data.search) search.value = res.data.search
            if(res.data.list) listField.value = res.data.list

            Post('FieldList',{table:res.data.name}).then(res1=>{
                for(let i in res1.data){
                    let vals = []
                    if(res1.data[i].type.indexOf('enum')!='-1' || res1.data[i].type.indexOf('set')!='-1'){
                        vals = res1.data[i].type.match(/'([^']+)'/g).map(option => option.replace(/'/g, ''));
                    }
                    for(let j in search.value){
                        if(search.value[j].name==res1.data[i].name){
                            search.value[j].vals = vals
                        }
                    }
                    for(let j in listField.value){
                        if(listField.value[j].field==res1.data[i].name){
                            listField.value[j].vals = vals
                        }
                    }
                }
            })
        }
    })
}

const getData = ()=>{
    let param = {}
    return ['ContentList',param]
}

const listEleme = ref(null)
const del = (ids)=>{
    listEleme.value.Del('',ids)
}
const addEdit = (item={},isEdit=false) => {
    if(!isEdit){
        if(item.id) listEleme.value.Edit('添加 '+ item.name + ' 的下级',{ pid:item.id, level:++item.level, })
        else listEleme.value.Edit('添加',{ pid:0, level:1, })
    } else listEleme.value.Edit('编辑 '+item.name,item)
}

const change = (changeField,changeVal,whereVal)=>{
    listEleme.value.Change('',changeField,changeVal,whereVal)
}
</script>

<style scoped>

</style>