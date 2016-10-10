<template>
            <div class="col-md-6">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Gate Range
                        <span class="pull-right">
                            Range:
                            <select style="width:50px;" id="gate-range" v-model="max_jumps">
                                <option class="form-control" v-for="n in 20" value=:n v-bind:selected="n == 15">{{n}}</option>
                            </select>
                        </span>
                    </div>

                    <div class="panel-body">
                        {{data}}
                    </div>
                </div>
            </div>
</template>

<script>
    export default {
        data(){
            return {
                'max_jumps': 15
            }
        },

        mounted() {
            console.log('gate-range module loaded');
            var vm = this.vm;

        }
    }
</script>
