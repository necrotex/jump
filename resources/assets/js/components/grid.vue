<template>
    <div>
        <ring-loader :loading="loading" :color="color" :size="size" class="loader"></ring-loader>

        <transition name="fade">
            <div v-show="loaded">
                <form id="search" class="pull-right">
                    Search <input name="query" v-model="search" class="form-control">
                </form>
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th v-for="key in columns"
                            @click="sortBy(key)"
                            :class="{ active: sortKey == key }">
                            {{ key }}
                        </th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="entry in filteredData">
                        <td v-for="key in columns">
                            {{entry[key]}}
                        </td>
                        <td>
                            <i class="material-icons action-icon" title="Add waypoint" v-if="auth"
                               v-on:click="addWaypoint(entry['id'])">add_location</i>
                            <i class="material-icons action-icon" title="Open dotlan"
                               v-on:click="openDotlan(entry['name'])">map</i>
                            <i class="material-icons action-icon" title="Open zkillboard"
                               v-on:click="openZkill(entry['id'])">change_history</i>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </transition>
    </div>
</template>

<script>
    export default {
        props: ['range', 'system', 'type'],
        replace: true,
        data(){
            var sortOrders = {};
            var columns = ['name', 'sec', 'region', 'distance', 'delta', 'kills'];

            columns.forEach((key) => {
                sortOrders[key] = -1;
            });

            return {
                sortKey: 'delta',
                systems: {},
                columns: columns,
                search: '',
                sortOrders: sortOrders,
                auth: window.Laravel.auth,
                loaded: false,
                loading: true,
                color: "#ddd",
                size: "50px"
            }
        },

        computed: {
            filteredData: function() {
                var sortKey = this.sortKey;
                var search = this.search && this.search.toLowerCase();
                var order = this.sortOrders[sortKey];
                var data = this.systems;

                if (search) {
                    data = data.filter(function (row) {
                        return Object.keys(row).some(function (key) {
                            return String(row[key]).toLowerCase().indexOf(search) > -1
                        })
                    })
                }

                if (sortKey) {
                    data = data.sort(function (a, b) {
                        a = a[sortKey];
                        b = b[sortKey];
                        return (a === b ? 0 : a > b ? 1 : -1) * order
                    })
                }

                return data;
            },

            filters: {
                capitalize: function(str){
                    return str.charAt(0).toUpperCase() + str.slice(1);
                }
            }
        },

        mounted() {
            console.log('gate-range module loaded');
            var vm = this.vm;
        },

        methods: {
            sortBy: function(key){
                this.sortKey = key;
                this.sortOrders[key] = this.sortOrders[key] * -1;
            },

            update: function () {
                var vm = this;
                vm.loaded = false;
                vm.loading = true;

                var body = {
                    range: this.range,
                    system: this.system,
                    type:  this.type
                };

                this.$http.post('/api/systems/range/', body).then((response) => {
                    vm.systems = response.body;
                    vm.loaded = true;
                    vm.loading = false;
                });

            },

            openDotlan: function(system){
                window.open("http://evemaps.dotlan.net/system/" + system, '_blank');
            },

            openZkill: function(system){
                window.open("https://zkillboard.com/system/" + system, '_blank');
            },

            addWaypoint: function(systemID){
                this.$http.post('/api/crest/waypoint', {'systemID': systemID});
            }
        },

        watch: {
            range: function (range) {
                this.update();
            },

            system: function (systemID) {
                this.update();
            }
        }
    }

</script>
