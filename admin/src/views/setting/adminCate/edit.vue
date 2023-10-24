<template>
    <table class="edit_table">
        <editTr label="栏目名称" required>
            <el-input clearable v-model="data.name" />
        </editTr>
        <editTr label="栏目类型">
            <el-radio-group v-model="data.type" required>
                <el-radio label="分类" border>分类</el-radio>
                <el-radio label="页面" border>页面</el-radio>
            </el-radio-group>
        </editTr>

        <template v-if="data.type=='页面'">
            <editTr label="栏目跳转路径" required>
                <el-input clearable v-model="data.path" />
            </editTr>
            <editTr label="栏目文件路径" required>
                <el-input clearable v-model="data.view" />
            </editTr>
            <editTr label="是否显示" required>
                <el-radio-group v-model="data.show">
                    <el-radio label="是">是</el-radio>
                    <el-radio label="否">否</el-radio>
                </el-radio-group>
            </editTr>
            <editTr label="选中状态的栏目id">
                <el-input clearable v-model="data.active" type="number" />
                <div class="tips">为空表示使用自身作为选中状态</div>
            </editTr>
            
        </template>
        <editTr label="栏目图标" v-if="data.level==1" tip="" required>
            <el-input clearable v-model="data.icon" />
            <div class="tips">
                <a href="https://element-plus.gitee.io/zh-CN/component/icon.html" target="_blank">查看可选图标</a>，示例：复制值“&lt;el-icon&gt;&lt;Notification /&gt;&lt;/el-icon&gt;”，填写值“Notification”
            </div>
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
    type:'分类',
    path:'',
    view:'',
    icon:'',
    show:'是',
    active:'',
})
ObjSetObj(props.data,data.value)

const submit = ()=>{
    if(!Error([
        [!data.value.name,'栏目名称不能为空'],
        [!data.value.type,'请选择栏目类型'],
        [(data.value.type == "页面" && !data.value.path),'栏目跳转路径不能为空'],
        [(data.value.type == "页面" && !data.value.view),'栏目文件路径不能为空'],
        [(data.value.type == "页面" && !data.value.show),'请选择是否显示'],
        [(data.value.level==1 && !data.value.icon),'请填写图标'],
    ])) return

    Post('AdminCateEdit',data.value).then(res=>{
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