<template>
    <n3-aside placement="left" :title="data.name" width="350px" ref="asideLeft" id="info-panel">

        <div class="link-icons">
            <a :href="dotlan" title="dotlan"><n3-icon type="map-marker"></n3-icon></a>
            <a :href="zkill" title="zkillboard"><n3-icon type="caret-down"></n3-icon></a>
        </div>

        <p>ID: {{data.id}}</p>
        <p>Region: {{data.region}}</p>
        <p>Security: {{data.sec}}</p>
        <p>Kills in the last hour: {{data.kills}}</p>
        <p>Kill delta: {{data.delta}}</p>

        <history-chart :system="data.id" css-classes="chart"></history-chart>

        <div class="action-buttons">
            <n3-button type="primary" size="lg" class="center-block">Set Waypoint</n3-button>
        </div>
    </n3-aside>
</template>

<script>
    import {EventBus} from '../EventBus';

    export default {

        mounted() {
            EventBus.$on('open-info-panel', (data) => {
                this.open(data.id);
            });
        },

        methods: {
            open(id) {
                axios.get('api/system/' + id)
                    .then((response) => {
                        this.data = response.data;
                        this.$refs.asideLeft.open()
                    });
            },

        },

        data() {
            return {
                data: {},
                history: {
                    data: {},
                    labels: {}
                }
            }
        },

        computed: {
            dotlan() {
                return 'http://evemaps.dotlan.net/system/' + this.data.name;
            },
            zkill() {
                return "https://zkillboard.com/system/" + this.data.id;
            }
        }
    }
</script>
