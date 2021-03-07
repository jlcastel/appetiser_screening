import App from './components/App'
import Vue from 'vue'
import vuetify from './vuetify'

require('./bootstrap');

window.Vue = require('vue').default;

const app = new Vue({
    vuetify,
    el: '#app',
    components: {
        'App': App,
    } 
});
