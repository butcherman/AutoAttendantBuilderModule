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
                                    @deleteNode="deleteNode"
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
    const requireComponent = require.context('../Components', true, /(FlowChart|Actions)\/[A-Za-z-0-9]\w+\.vue$/);
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
                lastId: 9,
                activeNode: null,
                nodes: [
                    // {
                    //     id           : 1,
                    //     parentId     : -1,
                    //     nodeComponent: 'incoming-lines',
                    //     data: {
                    //         nodeId     : 1,
                    //         valid      : false,
                    //         hasChildren: false,
                    //         headerText : 'Start Here',
                    //         lineList   : [''],
                    //     },
                    // },


///////////////////////////////////// Testing Data ////////////////////////////////////
                    {
                        id           : 1,
                        parentId     : -1,
                        nodeComponent: 'incoming-lines',
                        data: {
                            nodeId     : 1,
                            valid      : true,
                            hasChildren: true,
                            headerText : 'Incoming Numbers',
                            lineList   : ['(530) 223-2979'],
                        },
                    },
                    {
                        id           : 2,
                        parentId     : 1,
                        nodeComponent: 'greeting',
                        data: {
                            nodeId     : 2,
                            valid      : true,
                            hasChildren: true,
                            greetingTitle   : '24/7 Greeting',
                            greeting        : 'This is a Greeting',
                            availableOptions: [0,1,2,3,4,5,6,7,8,9],
                        },
                    },
                    {
                        id           : 3,
                        parentId     : 2,
                        nodeComponent: 'dial-option',
                        data: {
                            nodeId     : 3,
                            valid      : false,
                            hasChildren: false,
                            num: 11,
                            verbage: 'Time Out',
                            availableOptions: [0,1,2,3,4,5,6,7,8,9],
                        },

                    }
//////////////////////////////////////////////////////////////////////////////////////



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
            /**
             * If a one key dial option changed, we need to update the available options list
             */
            this.eventHub.$on('dial-option-changed', data => {
                let parent = this.nodes.find(el => el.id == this.activeNode.parentId);
                let availableOptions = parent.data.availableOptions;

                //  add the new option back in if it was valid
                if(Number(data.wasOption))
                {
                    availableOptions.push(data.wasOption);
                }

                //  Remove the new option from the availalbe list
                let index = availableOptions.indexOf(data.newOption);
                availableOptions.splice(index, 1);

                //  Resort the array to put everything in order
                availableOptions.sort((a, b) => { return a - b });

                //  push the new options to the children of the parent node
                this.nodes.forEach(node => {
                    if(node.parentId == parent.id)
                    {
                        node.data.availableOptions = availableOptions;
                    }
                });
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
            },
            /**
             * Delete the active Node from the flow tree - will also delete all child nodes
             */
            deleteNode()
            {
                let confirmed = false;

                if(!this.activeNode.hasChildren)
                {
                    confirmed = true;
                }
                else
                {
                    this.$bvModal.msgBoxConfirm('This will also delete any items below this option', {
                        title: 'Are You Sure?',
                        buttonSize: 'sm',
                        okVariant: 'danger',
                        okTitle: 'YES',
                        cancelTitle: 'NO',
                        footerClass: 'p-2',
                        hideHeaderClose: false,
                        centered: true
                    }).then(val => {
                        confirmed = val;
                    });
                }

                console.log(confirmed);
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
