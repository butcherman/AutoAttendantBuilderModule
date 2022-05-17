<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <h1 class="text-center">Auto Attendant Builder</h1>
            </div>
        </div>
        <div class="row justify-content-center p-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center" v-if="auth"><inertia-link as="b-button" size="sm" pill :href="route('dashboard')" variant="info">Return to Tech Bench</inertia-link></div>
                        <div class="row builder-diagram">
                            <div class="col-md-8 border h-100">
                                <div class="h-100">
                                    <flowy
                                        class="m-auto h-100"
                                        :nodes="nodes"
                                    ></flowy>
                                </div>
                            </div>
                            <div class="col-md-4 border">
                                <div id="builder-data">
                                    <h4 class="text-center">Click on a component to get started</h4>
                                </div>
                            </div>
                        </div>
                        <div class="row builder-data">
                            <div class="col border">something....</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue from 'vue';
    import FlowyPlugin from "@hipsjs/flowy-vue";
    import "@hipsjs/flowy-vue/dist/lib/flowy-vue.css";
    Vue.use(FlowyPlugin);

    // Flowchart Components
    import IncomingLines from '../Components/incomingLines.vue';

    //  Data Components
    import IncomingLineData from '../Components/incomingLineData.vue';


    Vue.component('IncomingLines', IncomingLines);
    Vue.component('IncomingLineData', IncomingLineData);

    export default {
        props: {
            auth: {
                type:    Boolean,
                default: false,
            }
        },
        data() {
            return {
                nodes: [
                    {
                        id: '1',
                        parentId: -1,
                        nodeComponent: 'incoming-lines',
                        data: {
                            headerText: 'Start Here'
                        },
                    },
                ]
            }
        },
        created() {
            //
            // console.log(this.chart);
        },
        mounted() {

            // const start = this.chart.addElement('Incoming Phone Numbers');
            // const A = this.chart.addElement("A", { label: "vscode" });
            // const B = this.chart.addElement("B", { label: "github" });
            // const C = this.chart.addElement("C", { label: "npm" });
            // idea.leadsTo(A).leadsTo(B);
            // A.leadsTo(C);

            // A.on("click", function() {
            //     console.log("click!");
            // });

        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            //
        },
    }
</script>

<style>
    .builder-diagram {
        height: 65vh;
    }
    .builder-data {
        min-height: 10vh;
    }
</style>
