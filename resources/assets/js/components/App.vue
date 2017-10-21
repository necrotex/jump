<template>
    <div class="wrapper">
        <n3-container fluid class="container">
            <n3-row>
                <n3-column :col="9" class="context map-grid">
                    <div v-show="loading" class="center">
                        <n3-loading center></n3-loading>
                    </div>
                    <dotlan-map v-show="!loading"></dotlan-map>
                </n3-column>
                <n3-column :col="3" class="context">
                    <fleet></fleet>
                </n3-column>
            </n3-row>
        </n3-container>

        <info-panel></info-panel>
        <context-menu></context-menu>
    </div>
</template>

<script>
    import {EventBus} from '../EventBus';

    export default {
        mounted() {
            let _this = this;

            EventBus.$on('map-loading', (loading) => {
                console.log('loading', loading);
                _this.loading = loading;
            });
        },

        data() {
            return {
                loading: false
            }
        }
    }
</script>