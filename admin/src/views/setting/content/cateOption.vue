<template>
<template v-for="item in list" >
<el-option :label="'|---'.repeat(item.level-1)+item.name" :value="item.id"/>
<cateOption v-if="item.children" :list="item.children" />
</template>
</template>

<script setup>
import cateOption from './cateOption.vue'
const props = defineProps(['list'])
</script>