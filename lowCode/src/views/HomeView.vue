<template>
    <add :data="(val:object)=>first=val" />
    <button @click="get">按钮</button>
</template>


<script setup lang="ts">
import { ref,onMounted } from "vue";
import add from "@/components/add.vue";

const first  = ref()

const get = ()=>{
    // console.log(first.value.a);
    first.value.num1 = 100
    first.value.num2 = 100
    first.value.x += 100
    console.log(first.value);
}
</script>

<style scoped>
</style>