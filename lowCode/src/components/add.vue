<template>
    <box :data="(val:object)=>{add(val)}"/>
</template>

<script setup lang="ts">
import { ref,onMounted, watch } from "vue";
import box from "@/components/box.vue";

const props = defineProps(['data'])

const data = ref()
const add = (val:any)=>{
    val.title = '加法'
    val.num1 = null
    val.num2 = null
    val.val = null
    data.value = val
    props.data(data.value)
}

watch(data,(newData)=>{
    if(newData.num1 && newData.num2) newData.title = newData.num1+'+'+newData.num2
    newData.val = newData.num1+newData.num2
},  { deep: true })
</script>

<style scoped>
</style>