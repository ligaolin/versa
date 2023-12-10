<template>
    <table class="edit_table">
        <editTr label="所属自定义内容" required> {{ data.content_name }} </editTr>
        <editTr label="英文名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="中文名称" required>
            <el-input clearable v-model="data.cname" />
        </editTr>
        <editTr label="字段类型" required>
            <el-select v-model="data.type">
                <el-option label="单行文本" value="单行文本" />
                <el-option label="单行整数" value="单行整数" />
                <el-option label="单行小数" value="单行小数" />
                <el-option label="多行文本" value="多行文本" />
                <el-option label="单选项" value="单选项" />
                <el-option label="多选项" value="多选项" />
                <el-option label="下拉菜单" value="下拉菜单" />
                <el-option label="上传图片" value="上传图片" />
                <el-option label="上传视频" value="上传视频" />
                <el-option label="上传文件" value="上传文件" />
                <el-option label="时间" value="时间" />
                <el-option label="日期" value="日期" />
                <el-option label="时间和日期" value="时间和日期" />
                <el-option label="编辑器" value="编辑器" />
                <el-option label="关联数据单选器" value="关联数据单选器" />
                <el-option label="关联数据多选器" value="关联数据多选器" />
            </el-select>
        </editTr>
        <editTr label="可否为空">
            <el-radio-group v-model="data.is_null">
                <el-radio label="可以">可以</el-radio>
                <el-radio label="不可以">不可以</el-radio>
            </el-radio-group>
        </editTr>
        <editTr label="可否重复">
            <el-radio-group v-model="data.is_repeat">
                <el-radio label="可以">可以</el-radio>
                <el-radio label="不可以">不可以</el-radio>
            </el-radio-group>
        </editTr>
        <editTr label="默认值">
            <el-input clearable v-model="data.default" />
        </editTr>
        <editTr label="可选值" v-if="data.type=='单选项' || data.type=='多选项' || data.type=='下拉菜单'" required>
            <el-input clearable v-model="data.vals" type="textarea" style="width:300px;"/>
            <div class="tips">多个可选值之间用“,”隔开</div>
        </editTr>
        <template v-if="data.type=='关联数据单选器' || data.type=='关联数据多选器'">
            <editTr label="关联表名称">
                <el-input clearable v-model="data.table" />
            </editTr>
            <editTr label="关联表的关联字段">
                <el-input clearable v-model="data.field" />
            </editTr>
            <editTr label="关联表的显示字段">
                <el-input clearable v-model="data.field_name" />
            </editTr>
        </template>
        <editTr label="提示">
            <el-input clearable v-model="data.tips" type="textarea" style="width:300px;"/>
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
    content_id:'',
    content_name:'',
    id:'',
    name:'',
    cname:'',
    type:'单行文本',
    is_null:'可以',
    is_repeat:'可以',
    default:'',
    vals:'',
    tips:'',
    table:'',
    field:'id',
    field_name:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.content_id,'所属自定义内容必须'],
        [!data.value.name,'英文名称必须'],
        [!data.value.type,'数据类型必须'],
        [((data.value.type=='单选项' || data.value.type=='多选项' || data.value.type=='下拉菜单') && !data.value.vals),'该类型可选值必须'],
        [((data.value.type=='关联数据单选器' || data.value.type=='关联数据多选器') && !data.value.table),'该类型关联表名称必须'],
        [((data.value.type=='关联数据单选器' || data.value.type=='关联数据多选器') && !data.value.field),'该类型关联表的关联字段必须'],
        [((data.value.type=='关联数据单选器' || data.value.type=='关联数据多选器') && !data.value.field_name),'该类型关联表的显示字段必须'],
    ])) return

    Post('ContentFieldEdit',data.value).then(res=>{
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