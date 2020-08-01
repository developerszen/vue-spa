import Vue from 'vue'
import App from './App.vue'
import router from './router'
import vuetify from './plugins/vuetify';

import { i18n } from "@/plugins/vue-i18n";
import '@/plugins/vee-validate';
import '@/plugins/vue-notification';
import '@/plugins/vue-moment';
import '@/router/interceptors';

Vue.config.productionTip = false


new Vue({
  i18n,
  router,
  vuetify,
  render: h => h(App)
}).$mount('#app')
