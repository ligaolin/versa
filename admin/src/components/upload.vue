<template>
<el-upload
    v-model:file-list="fileList"
    :action="http+'/api/admin/other.File/Upload'"
    :headers="headers"
    multiple
    ref="upload"
    :on-change="Change"
    :limit="limit"
    :accept="accept"
  >
    <el-button type="primary">上传文件</el-button>
    <template #file="{ file }">
        <template v-if="file.response && file.response.code && file.response.code==2000">
            <div v-if="file.response.data.type=='image' || file.response.data.type=='video'" class="thumb">
                <el-image class="image" v-if="file.response.data.type=='image'" :src="file.response.data.url" fit="cover" />
                <video class="video" v-if="file.response.data.type=='video'" :src="file.response.data.url" controls></video>
                
                <div class="operation">
                    <el-icon @click="preview(file.response.data)" color="white" :size="20"><Search /></el-icon>
                    <el-icon @click="remove(file)" color="white" :size="20"><Delete /></el-icon>
                </div>
            </div>
            <div v-else class="other">
                <div>{{ file.response.data.name }}</div>
                <el-icon @click="remove(file)" :size="20"><Delete /></el-icon>
            </div>
        </template>
    </template>
</el-upload>

<el-dialog v-model="previewShow" title="预览" width="80%" >
    <div class="previewBox">
        <el-image class="preview" v-if="previewItem.type=='image'" :src="previewItem.url" fit="contain" />
        <video class="preview" v-if="previewItem.type=='video'" :src="previewItem.url" controls></video>
    </div>
</el-dialog>

</template>

<script setup>
import { ref,watch } from 'vue'
import { http } from '@/data'
const emit = defineEmits(['change'])
const props = defineProps({
    list:{type:Array,default:[]},
    limit:{type:[String,Number],default:0},
    accept:{type:[String],default:'image/*'},
})
const fileList = ref([])
const upload = ref(null)
const headers = ref({Authorization:localStorage.getItem('adminToken')})

const previewShow = ref(false)
const previewItem = ref({})
const preview = (item)=>{
    previewItem.value = item
    previewShow.value = true
}

const setList = ()=>{
    let list = [];
    for(let i in fileList.value){
        if(fileList.value[i] && fileList.value[i].response && fileList.value[i].response.code){
            if(fileList.value[i].response.code==1000){
                ElMessage({message:fileList.value[i].response.msg,type:'error'})
                fileList.value.splice(i)
            }else if(fileList.value[i].response.code==2000) list.push(fileList.value[i].response.data)
        }
    }
    emit('change',list)
}

const remove = (file,files)=>{
    ElMessageBox.confirm('确定删除吗').then(()=>{
        upload.value.handleRemove(file)
        setList()
    })
}

const Change = (file,files) => {
    setList()
}

watch(()=>props.list, (newValue, oldValue) => {
    if((typeof props.list == 'object' || typeof props.list == 'array') && props.list && newValue.length>fileList.value.length){
        for(let i in newValue){
            fileList.value.push({response:{code:2000,data:newValue[i]}})
        }
    }
}, { immediate: true })
</script>

<style scoped>
.thumb{position:relative;display:inline-block;overflow: hidden;height: 100px;margin-bottom:15px;margin-right:10px;border-radius:5px;}
.thumb .image,.thumb .video{width:100px;height:100px;}
.thumb .operation{width:100px;height:100px;background:rgba(0,0,0,0.5);position:absolute;left:0;top:100px;transition:all 0.4s;display:flex; align-items: center; justify-content: center; }
.thumb:hover .operation{top:0;}
.thumb:hover .operation .el-icon{cursor: pointer;}
.thumb:hover .operation .el-icon:first-child{margin-right:10px;}

:deep .el-upload-list__item{display:initial;}
:deep .el-upload-list__item:hover{background:none;}
.preview{max-width:100%;}
.previewBox{text-align:center;}

.other{display: flex;margin-bottom:15px;}
.other .el-icon{margin-left:10px;align-items:center;cursor: pointer;}
</style>