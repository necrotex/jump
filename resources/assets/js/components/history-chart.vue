<script>
    import { Line, mixins } from 'vue-chartjs'

    let _vm;
    export default {
        extends: Line,
        mounted() {
            _vm = this; // somehow the the self reference with this is fucked so we do this as a work around...
            this.renderChart(_vm.collection, {responsive: true, maintainAspectRatio: false})
        },

        props: ['system'],

        data () {
            return {
                collection: {
                    labels: [],
                    datasets: [
                        {
                            label: 'NPC Kills last 48h',
                            backgroundColor: '#2C68CA',
                            data: []
                        }
                    ]
                }
            }
        },

        watch: {
            system: (id) => {
                _vm.update(id);
            }
        },

        methods: {
            update: (id) => {
                axios.get('api/system/' + id + '/history')
                    .then((response) => {
                        _vm.collection.labels = [];
                        _vm.collection.datasets.data = [];

                        for(let entry of response.data) {
                            console.log(entry.data);
                            _vm.collection.labels.push(entry.label);
                            _vm.collection.datasets[0].data.push(entry.data);
                        }

                        _vm.$data._chart.update();
                    });


            }
        }
    }
</script>
