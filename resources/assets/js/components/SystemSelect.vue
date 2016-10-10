<template>
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading">System</div>

                    <div class="panel-body system-select">
                        <select2 :options="options" v-model="selected">
                            <v-select
                                    :debounce="250"
                                    :on-search="getOptions"
                                    :options="options"
                                    placeholder="Enter a System"
                                    label="full_name"
                            >
                            </v-select>
                        </select2>
                    </div>
                </div>
            </div>
        </div>

</template>

<script type="text/x-template" id="select2-template">
    <select>
        <slot></slot>
    </select>
</script>

<script>
    import vSelect from "vue-select"

    export default {
        components: {vSelect},

        data() {
            return {
                options: null
            }
        },

        methods: {
            getOptions(search, loading) {
                loading(true);
                this.$http.get('/api/systems/autocomplete', {
                    q: search
                }).then(resp => {
                    this.options = resp.data.items;
                    loading(false)
                })
            }
        }
    }
</script>
