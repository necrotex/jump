
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('bootstrap-switch');


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the body of the page. From here, you may begin adding components to
 * the application, or feel free to tweak this setup for your needs.
 */

Vue.component('system-select', require('./components/SystemSelect.vue'));
Vue.component('grid', require('./components/grid.vue'));
Vue.component('location', require('./components/MyLocation.vue'));
Vue.component('range-select', require('./components/range-select.vue'));

const app = new Vue({
    el: '.content',

    data: {
        systemID: null,
        systemName: null,
        jdc: 5,
        range: 10,
        pre: null,
        auth: window.Laravel.auth,
        blopsJDC: true,
    },

    mounted: function () {
        var vm = this;
        $('[data-toggle="tooltip"]').tooltip();

        $("[name='jump-type']").bootstrapSwitch({
            size: 'mini',
            'onText': 'Blops',
            'offText': 'Capitals'
        }).on('switchChange.bootstrapSwitch', function(event, state){
            vm.blopsJDC = state;
        });


        var hash;
        if((hash = window.location.hash) != ""){
            this.prefetch(hash.substring(1));
        }
    },

    methods: {
        prefetch: function(system){
                this.pre = system;
        },

        updateSystems: function(systemID, systemName){
            this.systemID = systemID;
            this.systemName = systemName;
        },

        rangeChange: function(range){
            this.range = range;
        },

        jdcChange: function(jdc){
            this.jdc = jdc;
        },
        
        jdcToLightyear: function (jdc) {
            var range = {
                blops: {
                    1: 4.8,
                    2: 5.6,
                    3: 6.4,
                    4: 7.2,
                    5: 8,
                },
                'caps': {
                    1: 3,
                    2: 3.5,
                    3: 4,
                    4: 4.5,
                    5: 5,
                }
            };

            var type = (this.blopsJDC) ? 'blops' : 'caps';

            return range[type][jdc];
        }
    },

    computed: {
        lightyears: function(){
            return this.jdcToLightyear(this.jdc);
        }
    },

    watch: {
        systemName: function(val){
            window.location.hash = val;
        }
    }


});


