<template>
    <select type="text" class="form-control" id="system" v-model="system" placeholder="System"></select>
</template>

<script>
    require('select2');

    export default {
        props: ['prefetch'],

        data(){
            var vm = this;

            return {
                system: 0,
                select: null
            }
        },

        mounted() {
            console.log('system module loaded');

            var vm = this;

            this.select = $("#system")
                    .select2({
                        minimumInputLength: 2,
                        ajax: {
                            url: '/api/systems/autocomplete',
                            dataType: 'json',
                            placeholder: 'Enter a System',
                            delay: 250,
                            processResults: function (data) {
                                return {
                                    results: $.map(data, function (item) {
                                        return {
                                            text: item.solarSystemName,
                                            slug: item.solarSystemID,
                                            id: item.solarSystemID
                                        }
                                    })
                                };
                            }
                        }
                    })
                    .on('select2:select', function (name, value) {
                        vm.$emit('update', vm.select.val(), vm.select.text());
                        vm.system = vm.select.val();
                    });
        },

        watch: {
            prefetch: function(value){
                var vm = this;
                if(value != null) {
                    this.$http.get('/api/systems/autocomplete?q=' + value).then((response) => {
                        var option = new Option(response.body[0].solarSystemName, response.body[0].solarSystemID);
                        $(this.$el).append(option);
                        vm.select.val(response.body[0].solarSystemID).trigger('change');
                        vm.system = response.body[0].solarSystemID;
                        vm.$emit('update', vm.system, response.body[0].solarSystemName);
                    });
                }
            }
        }
    }
</script>
