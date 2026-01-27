// import { createApp } from 'vue'
// import App from './App.vue'
// import router from './router'  // <-- import router

// createApp(App)
//     .use(router)  // <-- use router
//     .mount('#app')


import './assets/main.css'
import './styles/global.css'
import 'bootstrap/dist/css/bootstrap.min.css'
import 'bootstrap/dist/js/bootstrap.bundle.min.js'
import 'bootstrap-icons/font/bootstrap-icons.css'

import { createApp } from 'vue'
import App from './App.vue'
import router from './router'

const app = createApp(App)
app.use(router)
app.mount('#app')