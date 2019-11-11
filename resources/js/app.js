window._ = require('lodash');
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
} else {
    console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
}

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));
// Google Maps
Vue.component('google-maps', require('./components/mapa-educativo/GoogleMaps.vue').default)
import * as VueGoogleMaps from "vue2-google-maps";

// SelectBox

Vue.component('select-api-forms',require('./components/mapa-educativo/selectbox.vue').default)

Vue.component('mapa-educativo', require('./components/mapa-educativo/MapaEducativo.vue').default)
Vue.component('super-componente', require('./components/SuperComponente.vue').default)

// Centros
Vue.component('secciones-exportar', require('./components/Exportacion.vue').default)

// Vue Select
import vSelect from 'vue-select'
Vue.component('v-select',vSelect)
import 'vue-select/dist/vue-select.css'


// Vuetify
// import Vuetify from 'vuetify'
// import 'vuetify/dist/vuetify.min.css'

// Vue.use(Vuetify);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyBFPUFES_l4Gn4QKty9nwXTdeM-Ew-Hxb8",
        libraries: "places" // necessary for places input
    }
});

const app = new Vue({
    el: '#vuelte'
});
