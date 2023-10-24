<template>
 <tr>
    <td valign="top" class="label">
        <span class="required" v-if="props.required">*</span>
        <span v-html="props.label"></span>
    </td>
    <td> <slot></slot> </td>
</tr>
</template>

<script setup>
const props = defineProps({
    label:{ type: String, default: '' },
    required:{ type: Boolean, default: false },
})
</script>

<style scoped>
.required{color:red;margin-right:3px;vertical-align:middle;font-weight:bold;}
.label{ padding-top: 16px;}
</style>