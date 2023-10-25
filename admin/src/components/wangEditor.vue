<template>
<div style="border: 1px solid #ccc;max-width:100%;">
      <Toolbar
        style="border-bottom: 1px solid #ccc"
        :editor="editorRef"
        :defaultConfig="toolbarConfig"
      />
      <Editor
        style="min-height:150px;"
        v-model="valueHtml"
        :defaultConfig="editorConfig"
        @onChange="handleChange"
        @onCreated="handleCreated"
      />
</div>
</template>

<script setup>
import '@wangeditor/editor/dist/css/style.css' // 引入 css
import { onBeforeUnmount,ref,shallowRef,onMounted,watch } from 'vue'
import { Editor, Toolbar } from '@wangeditor/editor-for-vue'
import { http } from '@/data'
const emit = defineEmits(['change'])
const props = defineProps({
    val:{type:String,default:''},
})

// 编辑器实例，必须用 shallowRef
const editorRef = shallowRef()
// 内容 HTML
const valueHtml = ref('')

watch(()=>props.val, (newValue, oldValue) => {
    if(typeof newValue == 'string') valueHtml.value = newValue
}, { immediate: true })

const toolbarConfig = {}
const upConfig = {
    maxFileSize: 20 * 1024 * 1024, // 20M
    fieldName:'file',
    headers:{Authorization:localStorage.getItem('adminToken')},
    server: http+'/api/admin/other.File/Upload',
    customInsert: (res,insertFn) => {
        if(res.code == 2000){
            insertFn(res.data.url);
        }else{
            ElMessage({message:res.msg,type:'error'})
        }
    },
}
const editorConfig = {
    placeholder: '请输入内容...',
    MENU_CONF : {
        uploadImage:upConfig,
        uploadVideo:upConfig,
    },
    zIndex : 500,
}

// 组件销毁时，也及时销毁编辑器
onBeforeUnmount(() => {
    const editor = editorRef.value
    if (editor == null) return
    editor.destroy()
})

const handleCreated = (editor) => {
    editorRef.value = editor // 记录 editor 实例，重要！
}

const handleChange = (editor) => {
    emit('change',editor.getHtml())
}
</script>

<style scoped>
:deep img,:deep video{max-width:100%;}
</style>