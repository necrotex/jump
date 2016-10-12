<template>
    <select style="width:50px;" :id="id" v-model="value">
        <option class="form-control" v-for="n in max" :value="n">{{n}}</option>
    </select>
</template>

<script>

    export default {
        props: ['id', 'max', 'selected'],

        data(){
            return {
                value: this.selected,
                system: this.system
            }
        },

        mounted() {
            console.log('Component ready.')
        },

        watch: {
            value: function(val){
                this.$emit('change', val);
            }
        }
    }
</script>