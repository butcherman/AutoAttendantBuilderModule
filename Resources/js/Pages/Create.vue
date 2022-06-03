<template>
    <div id="">
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
                                <flowy ref="flowyChart" :nodes="nodes"></flowy>
                            </div>
                        </div>
                        <div id="action-wrapper" class="row">
                            <div class="col-12 border p-2">
                                <component
                                    :is="activeNode.nodeComponent+'-action'"
                                    :node="activeNode"
                                    @giveBirth="giveBirth"
                                    @deleteMe="deleteActiveNode"
                                    @removeChildren="removeChildren"
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
                idIndex: 0,
                activeNode: {},
                nodes: [],
            }
        },
        created() {
            //
        },
        mounted() {
            /**
             * Create the initial node
             */
            this.createNode(-1, 'incoming-lines', {
                headerText: 'Start Here',
                lineList: [''],
            });
            /**
             * Capture a node click event to make it active
             */
            this.eventHub.$on('flow-component-click', data => {
                this.setActiveNode(data);
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
             * Create a new Flow Chart Node
             */
            createNode(parentId, nodeComponent, data)
            {
                this.nodes.push({
                    id: this.idIndex++,
                    parentId,
                    nodeComponent,
                    data,
                    valid      : false,
                    active     : false,
                    hasChildren: false,
                });

                this.activeNode.hasChildren = true;
            },
            /**
             * Gather the data for new child node and create it
             */
            giveBirth(data)
            {
                this.createNode(this.activeNode.id, data.component, data.data);
            },
            /**
             * Set the active node and remove active from all other
             */
            setActiveNode(node)
            {
                this.activeNode.active = false;
                this.activeNode = node;
                this.activeNode.active = true;
            },
            /**
             * Process for removing the selected (active) node and its children
             */
            deleteActiveNode()
            {
                this.$bvModal.msgBoxConfirm('Everything attached below this component will also be deleted.', {
                    title: 'Are You Sure?',
                    size: 'sm',
                    buttonSize: 'sm',
                    okVariant: 'danger',
                    okTitle: 'YES',
                    cancelTitle: 'NO',
                    footerClass: 'p-2',
                    hideHeaderClose: false,
                    centered: true
                })
                .then(value => {
                    if(value)
                    {
                        let parent = this.nodes.find(ele => { ele.id === parent });
                        this.removeChildren();
                        this.deleteNode(this.activeNode);
                        this.activeNode = {};
                        this.updateChildren();
                    }
                });
            },
            /**
             * Delete all Children nodes for the active node
             */
            removeChildren()
            {
                for(let node of this.nodes)
                {
                    if(node.parentId == this.activeNode.id)
                    {
                        this.deleteNode(node);
                        this.removeChildren();
                    }
                }
            },
            /**
             * Delete a node from the tree
             */
            deleteNode(node)
            {
                this.nodes.splice(this.nodes.indexOf(node), 1);
            },
            /**
             * Check all nodes to see if it has any children
             */
            updateChildren()
            {
                for(let node of this.nodes)
                {
                    let hasChild = false;

                    for(let child of this.nodes)
                    {
                        if(child.parentId === node.id)
                        {
                            hasChild = true;
                        }
                    }

                    node.hasChildren = hasChild;
                }
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
