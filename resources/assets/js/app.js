require('./bootstrap');

window.Vue = require('vue');
require('chart.js');

Vue.use(require('N3-components'), 'en');
Vue.use(require('vue-localstorage'));
Vue.use(require('vue-chartjs'));

Vue.component('app', require('./components/App.vue'));
Vue.component('dotlan-map', require('./components/Map.vue'));
Vue.component('fleet', require('./components/Fleet.vue'));
Vue.component('info-panel', require('./components/Aside.vue'));
Vue.component('context-menu', require('./components/SystemContextMenu.vue'));
Vue.component('history-chart', require('./components/history-chart.vue'));

const app = new Vue({
    el: '#app'
});
