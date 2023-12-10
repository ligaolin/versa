<template>
    <template v-for="item in list" >
        <el-option :label="'|---'.repeat(item.level-1)+item[text]" :value="item[value]"/>
        <levelOption v-if="item.children" :list="item.children" />
    </template>
</template>

<script setup>
import levelOption from './levelOption.vue'
const props = defineProps({
    list:{type:[Object,Array],defaullt:[]},
    value:{type:String,default:'id'},
    text:{type:String,default:'name'},
})
</script>