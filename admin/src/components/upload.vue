<template>
<el-upload
    v-model:file-list="fileList"
    class="upload-demo"
    action="http://127.0.0.1:8000/api/admin/other.File/Upload"
    :headers="headers"
    multiple
    :limit="3"
  >
    <el-button type="primary">Click to upload</el-button>
</el-upload>
</template>

<script setup>
import { ref } from 'vue'
import { ElMessage, ElMessageBox } from 'element-plus'
import { Post } from '@/api/api'


// FileUpload

// Post
const headers = ref({Authorization:localStorage.getItem('adminToken')})
const fileList = ref([])
</script>

<style scoped>

</style>