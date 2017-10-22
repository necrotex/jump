<template>
    <div class="context-menu" v-show="visable == true" :style="{top: x, left: y}" v-on:blur="close()">
        <ul>
            <li>A</li>
            <li>B</li>
        </ul>
    </div>
</template>

<script>
    import {EventBus} from '../EventBus';

    export default {

        mounted() {
            EventBus.$on('open-context-menu', (x, y) => {
                this.open(x, y);
            });
        },

        data() {
            return {
                visable: false,
                x: 0,
                y: 0
            }
        },

        methods: {
            open(x, y) {
                this.x = x + 'px';
                this.y = y + 'px';

                this.visable = true;
            },
            close() {
                this.visable = false;
            }
        }

    }
</script>
