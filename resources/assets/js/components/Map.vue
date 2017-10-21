<template>
    <div id="map"></div>
</template>

<script>
    import {EventBus} from '../EventBus';

    export default {
        mounted() {
            let Map = require('../Map');
            let _this = this;

            axios.get('/region/Catch')
                .then(response => {
                    EventBus.$emit('map-loading', true);

                    let mapElement = document.getElementById('map');

                    let map = new Map(JSON.parse(response.data), mapElement.width, mapElement.height, _this);
                    map.draw();

                    EventBus.$emit('map-loading', false);
                });
        },

        methods: {
            openInfoPanel(data) {
                EventBus.$emit('open-info-panel', data);
            },
            closeInfoPanel() {
                EventBus.$emit('close-info-panel');
            },

            openContextMenu(x, y) {
                EventBus.$emit('open-context-menu', x, y);
            }
        }
    }
</script>
