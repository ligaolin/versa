import { createApp } from 'vue'
import App from './App.vue'
const app = createApp(App)

import router from './router'
app.use(router)

import list from "@/components/list.vue"
import editTr from "@/components/editTr.vue"
import upload from '@/components/upload.vue'
import wangEditor from '@/components/wangEditor.vue'
app.component('list',list)
app.component('editTr',editTr)
app.component('upload',upload)
app.component('wangEditor',wangEditor)

import * as ElementPlusIconsVue from '@element-plus/icons-vue'
for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
    app.component(key, component)
}

app.mount('#app')
