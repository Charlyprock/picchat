import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import './index.css'
import axios from 'axios'
import VueAxios from 'vue-axios'
import { createI18n } from 'vue-i18n'
import Echo from "laravel-echo"

import store from './store/store'
import fonct from "./function/fonct.js"



window.Pusher = require('pusher-js');

window.Echo = new Echo({
  broadcaster: 'pusher',
  key: '87aa7d32909edcaaee0a',
  wsHost:'127.0.0.1',
  wsPort: 6001,
  cluster: "mt1",
  forceTLS: false,
  disableStats: true,
  authEndpoint :'http://127.0.0.1:8000/api/broadcasting/auth',
  auth:{
      headers: {
          Authorization: 'Bearer '+ store.state.token, 
      }
  },
 
});


const messages = {
  en: {
    messages: {
      hello: 'hello world',
    }
  },
  fr: {
    messages: {
      hello:'test',
      
    }
  },
}
// 2. Create i18n instance with options
const i18n = createI18n({
  locale: 'fr', // set locale
  fallbackLocale: 'fr', // set fallback locale
  messages, // set locale messages
  // If you need to specify other options, you can set other options
  // ...
})

const app = createApp(App)

app.config.globalProperties.$fonct = fonct

app.use(router).use(VueAxios, axios).use(i18n).use(store)
.mount('#app')






