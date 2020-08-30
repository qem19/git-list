import Vue from 'vue'
import App from './App.vue'
import Router from 'vue-router'
import router from './router'
import ElementUI from 'element-ui'
import "element-ui/lib/theme-chalk/index.css"
import AxiosConfigurator from "./api/AxiosConfigurator"

AxiosConfigurator.configure()

Vue.config.productionTip = false

Vue.use(Router)
Vue.use(ElementUI)

new Vue({
  router,
  render: h => h(App),
}).$mount('#app')
