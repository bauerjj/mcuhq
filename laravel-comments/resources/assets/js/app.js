import Vue from 'vue'
import VueI18n from 'vue-i18n'
import VueTimeago from 'vue-timeago'
require('iframe-resizer').iframeResizerContentWindow

import './components'
import './util/directives'
import store from './store'
import config from './config'

Vue.use(VueI18n)
Vue.config.lang = config.locale
Vue.locale(config.locale, config.translations)
Vue.config.productionTip = false

Vue.use(VueTimeago, {
  name: 'timeago',
  locale: config.locale,
  locales: {
    [config.locale]: config.translations.timeago
  }
})

new Vue({
  store,
  el: '#app',
  name: 'app'
})
