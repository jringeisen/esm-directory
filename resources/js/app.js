import { BootstrapVue } from 'bootstrap-vue'
import Vue2Filters from 'vue2-filters'
import VueMoment from 'vue-moment'



/** Import styling */
import 'bootstrap-vue/dist/bootstrap-vue.css'

/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
window.Vue = require('vue');


/**
 * Use npm packages
 */

Vue.use(BootstrapVue)
Vue.use(Vue2Filters)
Vue.use(VueMoment)

/**
 * Setup prototype variables to be used in vue components.
 */
Vue.prototype.$user = window.Laravel['user']
Vue.prototype.$role = window.Laravel['role']
Vue.prototype.$appName = 'ESM - Directory'

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

const files = require.context('./', true, /\.vue$/i)
files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
  el: '#app',
});
