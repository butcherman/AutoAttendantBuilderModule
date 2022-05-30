<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <h2 class="text-center">Auto Attendant Builder</h2>
            </div>
        </div>
        <div id="builder-wrapper" class="row justify-content-center p-4">
            <div class="col h-100">
                <div class="card h-100">
                    <div class="card-body h-100">
                        <div class="card-title text-center">
                            <inertia-link
                                v-if="auth"
                                as="b-button"
                                size="sm"
                                variant="info"
                                :href="route('dashboard')"
                                pill
                            >
                                Return to Tech Bench
                            </inertia-link>
                        </div>
                        <div id="flow-wrapper" class="row">
                            <div class="col-12 border clearfix">
                                <flowy :nodes="nodes"></flowy>
                            </div>
                        </div>
                        <div id="action-wrapper" class="row">
                            <div class="col-12 border p-2">
                                <component
                                    :is="actionComponent.type"
                                    v-bind="actionComponent.data"
                                    @saveData="saveData"
                                    @giveBirth="giveBirth"
                                ></component>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import Vue         from 'vue';
    import FlowyPlugin from "@hipsjs/flowy-vue";
    import upperFirst  from 'lodash/upperFirst';
    import camelCase   from 'lodash/camelCase';
    import "@hipsjs/flowy-vue/dist/lib/flowy-vue.css";

    Vue.use(FlowyPlugin);

    /**
     * Register all flow chart and Form Data components
     */
    const requireComponent = require.context('../Components', true, /(FlowChart || Actions)\/[A-Za-z-0-9]\w+\.vue$/);
    requireComponent.keys().forEach(fileName => {
        const componentConfig = requireComponent(fileName);
        const componentName   = upperFirst(camelCase(fileName.split('/').pop().replace(/\.\w+$/, '')));

        Vue.component( componentName, componentConfig.default || componentConfig);
    });

    export default {
        props: {
            auth: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                lastId: 2,
                activeNode: null,
                nodes: [
                    {
                        id           : 1,
                        parentId     : -1,
                        nodeComponent: 'incoming-lines',
                        data: {
                            nodeId     : 1,
                            valid      : false,
                            hasChildren: false,
                            headerText : 'Start Here',
                            lineList   : [''],
                        },
                    },
                ],
                actionComponent: {
                    type: null,
                    data: null,
                },
            }
        },
        created() {
            //
        },
        mounted() {
            /**
             * Open the Incoming Phone Lines form and load data
             */
            this.eventHub.$on('flow-component-click', data => {
                this.activeNode = this.nodes.find(el => el.id == data.nodeId);

                this.actionComponent = {
                    type: data.actionComponent,
                    data: this.activeNode.data,
                }
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
             * Save the form data to the active flow chart node
             */
            saveData(data)
            {
                this.activeNode.data      = data;
                this.actionComponent.data = data;
            },
            /**
             * Create a new Child Component
             */
            giveBirth(data)
            {
                this.lastId++;

                let defData         = data.data;
                defData.nodeId      = this.lastId;
                defData.valid       = false;
                defData.hasChildren = false;

                this.nodes.push({
                    id           : this.lastId,
                    parentId     : this.activeNode.id,
                    nodeComponent: data.type,
                    data         : defData,
                });

                this.activeNode.data.hasChildren = true;
            }
        },
    }
</script>

<style>
    #builder-wrapper {
        color: #000000;
        height: calc(100vh - 75px);
        overflow: auto;
    }

    #flow-wrapper {
        height: 80%;
        overflow: scroll;
        background-size: 20px 20px;
        background-image:
            linear-gradient(to right, rgba(231, 228, 228, 0.719) 1px, transparent 1px),
            linear-gradient(to bottom, rgba(231, 228, 228, 0.719) 1px, transparent 1px);
    }

    #action-wrapper {
        height: 10%;
    }

    .flowy-block {
        max-width: 250px;
    }
</style>
