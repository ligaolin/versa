<template>
<el-config-provider :locale="zhCn">
    <RouterView />
</el-config-provider>
</template>

<script setup>
import { RouterView } from 'vue-router'
import { ElConfigProvider } from 'element-plus'
import zhCn from 'element-plus/dist/locale/zh-cn.mjs'
</script>

<style>
body{margin:0;font-size:14px;}
*{box-sizing: border-box;}
a{text-decoration:none;color:#337ecc;}

.searchBar{padding:20px 0;}
.searchBar .el-input{width:150px;margin-right:8px;}
.searchBar .el-dropdown{margin:0 12px;}
.searchBar label{margin:0 10px 15px 0;display:inline-block;}

.edit_table{width:100%;}
.edit_table td:first-child{width:150px;text-align:right;}
.edit_table td{padding:10px;}
.edit_table .el-input,.edit_table .el-textarea{width:300px;}
.edit_table .el-radio{margin-right:15px;}
.edit_table .tips{margin-top:10px;}

.listTable{width:100%;}
.el-pagination{justify-content: center;align-items: center;margin-top: 20px;}
</style>
    