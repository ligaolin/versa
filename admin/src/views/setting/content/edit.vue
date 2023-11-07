<template>
    <table class="edit_table">
        <editTr label="英文名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="中文名称" required>
            <el-input clearable v-model="data.cname" />
        </editTr>
        <editTr label="选择所属栏目" required>
            <el-select v-model="data.cate_pid">
                <el-option label="请选择" value=""/>
                <levelOption :list="cateList" />
            </el-select>
        </editTr>
        <editTr label="默认字段">
            <el-checkbox label="id" :checked="true" disabled style="margin-bottom:5px;"/>
            <el-checkbox-group v-model="data.default_field">
                <el-checkbox style="display:block;" label="多级数据，包含字段：pid（上级ID）、level(第几级)"/>
                <el-checkbox style="display:block;" label="排序，包含字段：sort"/>
                <el-checkbox style="display:block;" label="状态，包含字段：state"/>
                <el-checkbox style="display:block;" label="更新时间，包含字段：created_at（添加）、updated_at（更新）"/>
            </el-checkbox-group>
        </editTr>

        <editTr label="搜索数据">
            中文名称<el-input clearable v-model="cname" class="w150" />
            英文名称<el-input clearable v-model="name" class="w150" />
            查询方式<el-select v-model="type" class="w150">
                <el-option label="等于" value="in"/>
                <el-option label="包含" value="like"/>
                <el-option label="不等于" value="!="/>
                <el-option label="大于" value=">"/>
                <el-option label="大于等于" value=">="/>
                <el-option label="小于" value="<"/>
                <el-option label="小于等于" value="<="/>
            </el-select>
            字段<el-input clearable v-model="field" class="w150"/>
            <el-button type="primary" @click="addSearth">添加</el-button>
            <div class="tips">
                字段与英文名称一样时可不填写
            </div>

            <el-table border v-if="data.search&&data.search.length" :data="data.search" style="margin-top:10px;">
                <el-table-column label="中文名称" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.cname" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="英文名称" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.name" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="查询方式" align="center">
                    <template #default="scope">
                        <el-select v-model="scope.row.type" class="wcover">
                            <el-option label="等于" value="in"/>
                            <el-option label="包含" value="like"/>
                            <el-option label="不等于" value="!="/>
                            <el-option label="大于" value=">"/>
                            <el-option label="大于等于" value=">="/>
                            <el-option label="小于" value="<"/>
                            <el-option label="小于等于" value="<="/>
                        </el-select>
                    </template>
                </el-table-column>
                <el-table-column label="字段" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.field" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="操作" align="center" width="200">
                    <template #default="scope">
                        <el-button type="danger" size="small" @click="del('search',scope)">删除</el-button>
                        <el-button v-if="scope.$index" size="small" @click="up('search',scope.$index)">向上</el-button>
                        <el-button v-if="scope.$index!=data.list.length-1 && data.search.length>1" size="small" @click="down('search',scope.$index)">向下</el-button>
                    </template>
                </el-table-column>
            </el-table>
        </editTr>

        <editTr label="列表数据">
            名称<el-input clearable v-model="listName" class="w150" />
            字段<el-input clearable v-model="listField" class="w150"/>
            类型<el-select v-model="listType" class="w150">
                <el-option label="文本显示" value="text"/>
                <el-option label="文本修改" value="input"/>
                <el-option label="开关" value="switch"/>
                <el-option label="图片或视频" value="media"/>
                <el-option label="自定义内容" value="html"/>
                <el-option label="操作" value="oper"/>
            </el-select>
            内容<el-input clearable v-model="listHtml" class="w200"/>
            可选操作<el-input clearable v-model="listOper" class="w200"/>
            <el-button type="primary" @click="addList">添加</el-button>
            <div class="tips">
                内容：仅类型为自定义内容时必须<br/>
                可选操作：仅类型为操作时必须，可选值：编辑、删除、添加下级，多个可选操作之间用“,”隔开，最后添加“|数字”可控制最多可添加层级，示例：“编辑,删除,添加下级|3”
            </div>

            <el-table border v-if="data.list&&data.list.length" :data="data.list" style="margin-top:10px;">
                <el-table-column label="名称" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.name" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="字段" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.field" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="类型" align="center">
                    <template #default="scope">
                        <el-select v-model="scope.row.type" class="wcover">
                            <el-option label="文本显示" value="text"/>
                            <el-option label="文本修改" value="input"/>
                            <el-option label="开关" value="switch"/>
                            <el-option label="图片或视频" value="media"/>
                            <el-option label="自定义内容" value="html"/>
                            <el-option label="操作" value="oper"/>
                        </el-select>
                    </template>
                </el-table-column>
                <el-table-column label="内容" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.html" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="可选操作" align="center">
                    <template #default="scope">
                        <el-input clearable v-model="scope.row.oper" class="wcover"/>
                    </template>
                </el-table-column>
                <el-table-column label="操作" align="center" width="200">
                    <template #default="scope">
                        <el-button type="danger" size="small" @click="del('list',scope)">删除</el-button>
                        <el-button v-if="scope.$index" size="small" @click="up('list',scope.$index)">向上</el-button>
                        <el-button v-if="scope.$index!=data.list.length-1 && data.list.length>1" size="small" @click="down('list',scope.$index)">向下</el-button>
                    </template>
                </el-table-column>
            </el-table>
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
import levelOption from '@/components/levelOption.vue'
const props = defineProps(['data'])
const emit = defineEmits(['submit'])

const data = ref({
    id:'',
    name:'',
    cname:'',
    cate_pid:'',
    cate_id:'',
    default_field:[],
    search:[],
    list:[],
})
ObjSetObj(props.data,data.value)
if(!data.value.search) data.value.search = []
if(!data.value.list) data.value.list = []
if(!data.value.default_field) data.value.default_field = []
const submit = ()=>{
    if(!Error([
        [!data.value.name,'英文名称必须'],
        [!data.value.cname,'中文名称必须'],
        [!data.value.cate_pid,'所属栏目必须'],
    ])) return
    if(data.value.search && data.value.search.length){
        for(let i in data.value.search){
            if(!data.value.search[i].cname) {ElMessage({message:'搜索数据中文名称不能为空',type:'error'});return false;}
            if(!data.value.search[i].name) {ElMessage({message:'搜索数据英文名称不能为空',type:'error'});return false;}
            if(!data.value.search[i].type) {ElMessage({message:'搜索数据查询方式不能为空',type:'error'});return false;}
        }
    }
    if(data.value.list && data.value.list.length){
        for(let i in data.value.list){
            if(!data.value.list[i].name) {ElMessage({message:'列表数据名称不能为空',type:'error'});return false;}
            if(data.value.list[i].type!='html' && data.value.list[i].type!='oper' && !data.value.list[i].field) {ElMessage({message:'列表数据字段不能为空',type:'error'});return false;}
            if(!data.value.list[i].type) {ElMessage({message:'列表数据类型不能为空',type:'error'});return false;}
            if(data.value.list[i].type=='html' && !data.value.list[i].html) {ElMessage({message:'列表数据类型为自定义内容时，内容不能为空',type:'error'});return false;}
        }
    }

    Post('ContentEdit',data.value).then(res=>{
        if(res.code == 2000){
            ElMessage({message:res.msg,type:'success'})
            emit('submit')
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    })
}

const cateList = ref([])
Post('AdminCateGetListByPid').then(res=>{
    if(res.code==2000) cateList.value = res.data
})

const name = ref('')
const cname = ref('')
const type = ref('in')
const field = ref('')
const addSearth = ()=>{
    data.value.search.push({name:name.value,cname:cname.value,type:type.value,field:field.value})
    name.value = ''
    cname.value = ''
    type.value = 'in'
    field.value = ''
}

const listName = ref('')
const listField = ref('')
const listType = ref('text')
const listHtml = ref('')
const listOper = ref('')
const addList = ()=>{
    data.value.list.push({name:listName.value,type:listType.value,field:listField.value,html:listHtml.value,oper:listOper.value})
    listName.value = ''
    listField.value = ''
    listType.value = 'text'
    listHtml.value = ''
    listOper.value = ''
}
const del = (type,res)=>{
    ElMessageBox.confirm('确定删除吗').then(()=>{
        data.value[type].splice(res.$index,1)
    }).catch(()=>{})
}
const down = (type,index)=>{
    let item = data.value[type][index+1]
    data.value[type][index+1] = data.value[type][index]
    data.value[type][index] = item
}
const up = (type,index)=>{
    let item = data.value[type][index-1]
    data.value[type][index-1] = data.value[type][index]
    data.value[type][index] = item
}
</script>

<style scoped>
.w150{width:150px;margin-right:20px;margin-left:5px;margin-bottom:10px;vertical-align:initial;}
.w150 :deep .el-input{width:150px;}
.w200{width:200px;margin-right:20px;margin-left:5px;margin-bottom:10px;vertical-align:initial;}
.w200 :deep .el-input{width:200px;}
.wcover,.wcover :deep .el-input{width:100%;}
</style>