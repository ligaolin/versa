<template>
<el-image class="image" :style="{width:width,height:height}" @click="preview(item)" v-if="item.type=='image'" :src="item.path?http+item.path:''" :fit="fit" />
<video class="video" @click="preview(item)" v-else-if="item.type=='video'" :src="item.path?http+item.path:''" :style="{width:width,height:height}"/>

<el-dialog v-model="previewShow" title="预览" width="80%" append-to-body>
    <div class="previewBox">
        <el-image class="preview" v-if="previewItem.type=='image'" :src="http+previewItem.path" fit="contain" />
        <video class="preview" v-else-if="previewItem.type=='video'" :src="http+previewItem.path" controls></video>
    </div>
</el-dialog>
</template>

<script setup>
import { http } from "@/data";
import { ref,watch } from 'vue'
const props = defineProps({
    item:{type:[Object,Array],defaullt:[]},
    width:{type:String,default:'70px'},
    height:{type:String,default:'70px'},
    fit:{type:String,default:'cover'},
})

const previewShow = ref(false)
const previewItem = ref({})
const preview = (item)=>{
    previewItem.value = item
    previewShow.value = true
}

const item = ref({ type:'', path:''})
const setData = ()=>{
    if(props.item){
        if(Array.isArray(props.item) && props.item.length){
            item.value = props.item[0]
        }else if(typeof props.item == 'object'){
            item.value = props.item
        }
    }
}
setData()
watch(()=>props.item,()=>{
    setData()
})
</script>

<style scoped>
.image,.video{cursor:pointer;} 
.preview{max-width:100%;}
.previewBox{text-align:center;}
</style>