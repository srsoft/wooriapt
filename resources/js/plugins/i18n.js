import Vue from 'vue'
import store from '~/store'
import VueI18n from 'vue-i18n'
import BootstrapVue from 'bootstrap-vue'
import VueMoment from 'vue-moment'
import Sticky from 'vue-sticky-directive'

Vue.use(BootstrapVue)
Vue.use(VueI18n)
Vue.use(VueMoment)
Vue.use(Sticky)

const i18n = new VueI18n({
  locale: 'en',
  messages: {}
})

/**
 * @param {String} locale
 */
export async function loadMessages (locale) {
  if (Object.keys(i18n.getLocaleMessage(locale)).length === 0) {
    const messages = await import(/* webpackChunkName: '' */ `~/lang/${locale}`)
    i18n.setLocaleMessage(locale, messages)
  }

  if (i18n.locale !== locale) {
    i18n.locale = locale
  }
}

;(async function () {
  await loadMessages(store.getters['lang/locale'])
})()

export default i18n
