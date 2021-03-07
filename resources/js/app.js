import Vue from 'vue'
import vuetify from './vuetify'

import App from './components/App'

require('./bootstrap');

window.Vue = require('vue').default;

// Vue.component( 'header-bar', require('./components/Sample.vue').default);

const app = new Vue({
    vuetify,
    el: '#app',
    components: {
        'App': App,
    } 
});
