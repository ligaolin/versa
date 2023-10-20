<template>
 <tr>
    <td v-html="props.label"></td>
    <td> <slot></slot> </td>
</tr>
</template>

<script setup>
const props = defineProps(['label'])
</script>