<template>
        <a href="#" data-toggle="tooltip" data-placement="top" title="Use my current location">
            <i class="material-icons" v-on:click="getLocation()" v-show="!loading">my_location</i>
        </a>
</template>

<script>
    export default {
        mounted() {
            console.log('Component ready.')
        },

        data(){
            return {
                loading: false,
            }
        },

        methods: {
            getLocation: function(e){
                var vm = this;
                this.loading = true;

                this.$http.get('/api/crest/location').then((response) => {
                    vm.notFound = false;
                    if(response.body.length == 0) {
                        vm.notFound = true;
                        return;
                    }

                    vm.$emit('update', response.body.systemID, response.body.systemName);
                    vm.loading = false;
                });

            }
        }
    }
</script>
