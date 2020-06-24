require('./bootstrap');

window.Vue = require('vue');

Vue.component('fa', require('@fortawesome/vue-fontawesome').FontAwesomeIcon);

import router from './router';
import store from './store';

import App from './components/App';

const app = new Vue({
    router,
    store,

    el: '#app',

    components: {
        App
    }
});
