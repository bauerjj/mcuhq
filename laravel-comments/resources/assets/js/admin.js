import Vue from 'vue'
import './util/directives'
import axios from 'axios'
import config from './config'
import VueI18n from 'vue-i18n'
import VueTimeago from 'vue-timeago'
import { HasError4, AlertSuccess } from 'vform'
import Settings from './components/admin/Settings'
import Dashboard from './components/admin/Dashboard.vue'

Vue.use(VueI18n)
Vue.config.lang = config.locale
Vue.locale(config.locale, config.translations)
Vue.config.productionTip = false

Vue.component(HasError4.name, HasError4)
Vue.component(AlertSuccess.name, AlertSuccess)

Vue.use(VueTimeago, {
  name: 'timeago',
  locale: config.locale,
  locales: {
    [config.locale]: config.translations.timeago
  }
})

new Vue({
  el: '#app',

  name: 'app',

  components: {
    Settings,
    Dashboard
  },

  methods: {
    logout () {
      axios.post('/comments/admin/logout')
        .then(() => {
          window.location.href = '/'
        })
    },

    toggleNavbar () {
      document.querySelector('.navbar-collapse').classList.toggle('show')
    }
  }
})
