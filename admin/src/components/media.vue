<template>
<el-image class="image" :style="{width:width,height:height}" @click="preview(item)" v-if="item.type=='image'" :src="item.url?item.url:''" :fit="fit" />
<video class="video" @click="preview(item)" v-else-if="item.type=='video'" :src="item.url?item.url:''" :style="{width:width,height:height}"/>

<el-dialog v-model="previewShow" title="预览" width="80%" append-to-body>
    <div class="previewBox">
        <el-image class="preview" v-if="previewItem.type=='image'" :src="previewItem.url" fit="contain" />
        <video class="preview" v-else-if="previewItem.type=='video'" :src="previewItem.url" controls></video>
    </div>
</el-dialog>
</template>

<script setup>
import { ref } from 'vue'
const props = defineProps({
    item:{type:Object,defaullt:{}},
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
</script>

<style scoped>
.image,.video{cursor:pointer;} 
.preview{max-width:100%;}
.previewBox{text-align:center;}
</style>