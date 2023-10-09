<template>
<Vue3DraggableResizable contenteditable
    :initW="box.w"
    :initH="box.h"
    v-model:x="box.x"
    v-model:y="box.y"
    v-model:w="box.w"
    v-model:h="box.h"
    v-model:active="box.active"
    :draggable="true"
    :resizable="true"
    @activated="box.activated('activated')"
    @deactivated="box.deactivated('deactivated')"
    @drag-start="box.dragStart('drag-start')"
    @resize-start="box.resizeStart('resize-start')"
    @dragging="box.dragging('dragging')"
    @resizing="box.resizing('resizing')"
    @drag-end="box.dragEnd('drag-end')"
    @resize-end="box.resizeEnd('resize-end')"
    :style="{
        'border-color':box.borderColor,
        'background-color':box.backgroundColor,
        'border-radius':box.borderRadius+'px',
        'line-height':box.lineHeight+'px',
        'text-align':box.textAlign,
    }"
>
    {{box.title}}
</Vue3DraggableResizable>
</template>

<script setup lang="ts">
import { ref } from "vue";
const props = defineProps(['data'])

const box = ref({
    node : null,
    title : '空白',
    borderColor : '#e5e5e5',
    backgroundColor : 'white',
    borderRadius:'5',
    lineHeight:'47',
    textAlign:'center',

    x :300,
    y :100,
    h :50,
    w :50,
    active : false,
    activated(val:string){ console.log(val); },
    deactivated(val:string){ console.log(val); },
    dragStart(val:string){ console.log(val); },
    resizeStart(val:string){ console.log(val); },
    dragging(val:string){ console.log(val); },
    resizing(val:string){ console.log(val); },
    dragEnd(val:string){ console.log(val); },
    resizeEnd(val:string){ console.log(val); },
})

props.data(box.value);
// defineExpose(box.value)
</script>

<style scoped>
</style>