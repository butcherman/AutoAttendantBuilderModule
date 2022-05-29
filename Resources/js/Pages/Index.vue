<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <h2 class="text-center">Auto Attendant Builder</h2>
            </div>
        </div>
        <div class="row justify-content-center p-4">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center" v-if="auth">
                            <inertia-link as="b-button" size="sm" pill :href="route('dashboard')" variant="info">
                                Return to Tech Bench
                            </inertia-link>
                        </div>
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
                                <div id="form-data" ref="form-data" class="my-2 h-100">
                                    <b-overlay :show="loading">
                                        <template #overlay>
                                            <atom-loader text="loading..."></atom-loader>
                                        </template>
                                        <component
                                            :is="formComponent.type"
                                            v-bind="formComponent.data"
                                            @save="saveData"
                                            @changeButtons="changeButtons"
                                        ></component>
                                    </b-overlay>
                                </div>
                            </div>
                        </div>
                        <div class="row builder-data">
                            <div class="col border text-center p-2">
                                <div>
                                    <b-button v-if="allowSchedule" pill variant="info" @click="addSchedule">Add Schedule</b-button>
                                    <b-button v-if="allowGreeting" pill variant="info" @click="addGreeting('24/7 Greeting')">Add Greeting</b-button>
                                    <b-button v-if="allowOption"   pill variant="info" @click="addOption('Press ?')">Add Option</b-button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    /**
     * Vue Flowy
     */
    import Vue from 'vue';
    import FlowyPlugin from "@hipsjs/flowy-vue";
    import "@hipsjs/flowy-vue/dist/lib/flowy-vue.css";
    Vue.use(FlowyPlugin);
    import upperFirst from 'lodash/upperFirst';
    import camelCase from 'lodash/camelCase';

    //  Import base components
    import BlankData from '../Components/Base/blankData.vue';
    Vue.component('BlankData', BlankData);

    /**
     * Register all flow chart and Form Data components
     */
    const requireComponent = require.context('../Components', true, /(FormData || FlowChart)\/[A-Za-z-0-9]\w+\.vue$/);
    requireComponent.keys().forEach(fileName => {
        const componentConfig = requireComponent(fileName);
        const componentName   = upperFirst(camelCase(fileName.split('/').pop().replace(/\.\w+$/, '')));

        Vue.component( componentName, componentConfig.default || componentConfig);
    });

    export default {
        props: {
            /**
             * If the visiter is a logged in user, they can return to the Tech Bench
             */
            auth: {
                type:    Boolean,
                default: false,
            }
        },
        data() {
            return {
                loading      : false,
                selectedId   : null,
                lastId       : 1,
                allowSchedule: false,
                allowGreeting: false,
                allowOption  : false,
                formComponent: {
                    type: 'blank-data',
                    data: null,
                },
                nodes: [
                    {
                        id           : 1,
                        parentId     : -1,
                        nodeComponent: 'incoming-lines',
                        data: {
                            nodeId    : 1,
                            valid     : false,
                            headerText: 'Start Here',
                            lineList  : [''],
                        },
                    },
                ],

            }
        },
        created() {
            //
        },
        mounted() {
            /**
             * Open the Incoming Phone Lines form and load data
             */
            this.eventHub.$on('incoming-line-click', data => {
                this.loading       = true;
                this.selectedId    = data.nodeId;
                this.formComponent = {
                    type: 'incoming-line-data',
                    data: {
                        lineList: data.data,
                        nodeId  : data.nodeId,
                    }
                }
                this.loading = false;
            });

            /**
             * Open the Schedule form and load data
             */
            this.eventHub.$on('schedule-click', data => {
                this.loading       = true;
                this.selectedId    = data.nodeId;
                this.formComponent = {
                    type: 'schedule-data',
                    data: {
                        nodeId  : data.nodeId,
                        schedule: data.data,
                    }
                }
                this.loading = false;
            });

            /**
             * Open the Greeting form and load data
             */
            this.eventHub.$on('greeting-click', data => {
                this.loading       = true;
                this.selectedId    = data.nodeId;
                this.formComponent = {
                    type: 'greeting-data',
                    data: {
                        nodeId       : data.nodeId,
                        greetingTitle: data.title,
                        greeting     : data.greeting,
                    }
                }
                this.loading = false;
            });

            /**
             * Open the Dial Option form and load data
             */
            this.eventHub.$on('dial-option-click', data => {
                this.loading       = true;
                this.selectedId    = data.nodeId;
                this.formComponent = {
                    type: 'dial-opt-data',
                    data: {
                        nodeId: data.nodeId,
                        option: data.option,
                    }
                }
                this.loading = false;
            })

            /**
             * Create the on and off hours greetings
             */
            this.eventHub.$on('create-schedule-greetings', () => {
                this.addGreeting('On Hours Greeting');
                this.addGreeting('Off Hours Greeting');
            });

            /**
             * Add the options mentioned in the greeting to the flow chart
             */
            this.eventHub.$on('create-options', data => {
                data.data.forEach(opt => {
                    this.addOption(opt);
                });
            });

            /**
             * Change the buttons for adding options
             */
            this.eventHub.$on('change-buttons', data => {
                this.allowSchedule = data.allowSchedule;
                this.allowGreeting = data.allowGreeting;
                this.allowOption   = data.allowOption;
            });
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            /**
             * Save the data from the form section to the proper node
             */
            saveData(data)
            {
                this.loading  = true;
                //  Save the data to the Node Array to update the flow chart
                const nodeKey = this.nodes.find(el => el.id == data.nodeId);
                nodeKey.data  = data.data;

                //  Re-populate the props on the selected component to allow reset to this state
                this.formComponent.data = data.data;

                this.loading  = false;
            },
            /**
             * Enable or disable buttons
             */
            changeButtons(data)
            {
                this.allowSchedule = data.allowSchedule;
                this.allowGreeting = data.allowGreeting;
                this.allowOption   = data.allowOption;
            },
            /**
             * Add a Schedule element to the flow tree
             */
            addSchedule()
            {
                this.lastId++;
                const nodeData = {
                    id           : this.lastId,
                    parentId     : this.selectedId,
                    nodeComponent: 'schedule',
                    data: {
                        //  Default data for a new schedule
                        nodeId  : this.lastId,
                        valid   : false,
                        schedule: {
                            title   : 'Business-Hours',
                            schedule: [
                                {
                                    start_time: '08:00',
                                    stop_time : '17:00',
                                    days      : ['mon', 'tue', 'wed', 'thu', 'fri'],
                                }
                            ]
                        },
                    },
                }

                this.nodes.push(nodeData);
                this.allowSchedule = false;
                this.allowGreeting = false;
            },
            /**
             * Add a greeting element to the flow chart
             */
            addGreeting(title)
            {
                this.lastId++;
                const nodeData = {
                    id           : this.lastId,
                    parentId     : this.selectedId,
                    nodeComponent: 'greeting',
                    data: {
                        //  Default data for a new greeting
                        nodeId       : this.lastId,
                        greetingTitle: title,
                        greeting     : '',
                        usedOptions  : [],
                        valid        : false,
                    },
                }

                this.nodes.push(nodeData);
                this.allowSchedule = false;
                this.allowGreeting = false;
            },
            /**
             * Add a one key dial option to the flow chart
             */
            addOption(opt)
            {
                console.log(opt);

                this.lastId++;
                const nodeData = {
                    id           : this.lastId,
                    parentId     : this.selectedId,
                    nodeComponent: 'dial-opt',
                    data: {
                        //  Default data for a new dial option
                        nodeId: this.lastId,
                        valid: false,
                        title: opt,
                    },
                }

                this.nodes.push(nodeData);
            }
        }
    }
</script>

<style>
    .builder-diagram {
        min-height: 65vh;
    }
    .builder-data {
        min-height: 10vh;
    }
    .flowy-block {
        max-width: 250px;
        max-height: 500px;
    }
</style>
