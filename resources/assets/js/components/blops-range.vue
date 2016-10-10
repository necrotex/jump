<template>

            <div class="col-md-6" >
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Jump Range
                        <span class="pull-right">
                            JDC:
                            <select style="width:50px;" id="gate-range">
                                <option class="form-control" v-for="n in 5" value=:n v-bind:selected="n == 5">{{n}}</option>
                            </select>
                        </span>
                    </div>

                    <div class="panel-body">
                        I'm an example component!
                    </div>
                </div>
            </div>
</template>

<script>
    export default {
        mounted() {
            console.log('blops-range module loaded.')
        }
    }
</script>
