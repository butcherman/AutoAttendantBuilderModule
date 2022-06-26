<template>
    <div id="flow-body">
        <div id="flow-wrapper" class="row">
            <div class="col-12 border clearfix">
                <flowy ref="flowyChart" :nodes="flowStore.nodes"></flowy>
            </div>
        </div>
        <div id="action-wrapper" class="row">
            <div class="col-12 border p-2">
                <div class="float-left">
                    <b-button
                        size="sm"
                        title="Save"
                        variant="primary"
                        pill
                        v-b-tooltip.hover
                        @click="saveCallTree"
                    >
                        <i class="fas fa-save" />
                    </b-button>
                     <b-button
                        size="sm"
                        title="Download"
                        variant="primary"
                        pill
                        v-b-tooltip.hover
                        @click="download"
                    >
                        <i class="fas fa-download" />
                    </b-button>
                     <b-button
                        size="sm"
                        title="Start Over"
                        variant="primary"
                        pill
                        v-b-tooltip.hover
                        @click="reset"
                    >
                        <i class="fas fa-retweet" />
                    </b-button>
                </div>
                <component
                    :is="`${activeNode.nodeComponent}-action`"
                    :node="activeNode"
                    @delete_me="deleteNode"
                ></component>
            </div>
        </div>
    </div>
</template>

<script>
    import guest from '../../../../../resources/js/Layouts/guest';
    import Layout from '../Template/Layout.vue';

    import { useFlowStore }            from '../Stores/flowStore';
    import { mapStores }               from 'pinia';
    import { DefaultIncomingLineData } from '../Modules/defaultData';

    import Vue         from 'vue';
    import FlowyPlugin from "@hipsjs/flowy-vue";
    import upperFirst  from 'lodash/upperFirst';
    import camelCase   from 'lodash/camelCase';

    import "@hipsjs/flowy-vue/dist/lib/flowy-vue.css";

    Vue.use(FlowyPlugin);

    /**
     * Register all flow chart and Form Data components
     */
    const requireComponent = require.context(
        '../Components',
        true,
        /(FlowChart|Actions)\/[A-Za-z-0-9]\w+\.vue$/
    );

    requireComponent.keys().forEach(fileName => {
        const componentConfig = requireComponent(fileName);
        const componentName   = upperFirst(camelCase(fileName.split('/')
                                                        .pop()
                                                        .replace(/\.\w+$/, '')));

        Vue.component( componentName, componentConfig.default || componentConfig);
    });

    export default {
        layout: [ guest, Layout ],
        props: {
            node_data: {
                type    : Array,
                required: false,
            },
            aa_link: {
                type   : String,
                default: null,
            }
        },
        data() {
            return {
                activeNode: {},
            }
        },
        created() {
            //
        },
        mounted() {
            this.initialize();
            /**
             * Capture a node click event to make it active
             */
            this.eventHub.$on('flow-component-click', data => {
                this.setActiveNode(data);
            });
        },
        computed: {
            ...mapStores(useFlowStore),
        },
        watch: {
            //
        },
        methods: {
            initialize()
            {
                if(this.node_data)
                {
                    this.flowStore.nodes = this.node_data;
                }
                else
                {
                    this.flowStore.nodes = [];
                    this.flowStore.buildNode(
                        -1,
                        'incoming-lines',
                        new DefaultIncomingLineData
                    );
                }
            },
            /**
             * Set the active node and remove active from all other
             */
            setActiveNode(node)
            {
                this.activeNode.active = false;
                this.activeNode        = node;
                this.activeNode.active = true;
            },
            deleteNode()
            {
                this.$bvModal.msgBoxConfirm('Everything below this point will also be destroyed',
                {
                    title          : 'Are you sure?',
                    size           : 'sm',
                    buttonSize     : 'sm',
                    okVariant      : 'danger',
                    okTitle        : 'YES',
                    cancelTitle    : 'NO',
                    footerClass    : 'p-2',
                    hideHeaderClose: false,
                    centered       : true
                }).then(value => {
                    if(value)
                    {
                        this.flowStore.destroyNode(this.activeNode);
                        this.activeNode = {};
                    }
                });
            },
            reset()
            {
                this.$bvModal.msgBoxConfirm('All progress will be lost',
                {
                    title          : 'Are you sure?',
                    size           : 'sm',
                    buttonSize     : 'sm',
                    okVariant      : 'danger',
                    okTitle        : 'YES',
                    cancelTitle    : 'NO',
                    footerClass    : 'p-2',
                    hideHeaderClose: false,
                    centered       : true
                }).then(value => {
                    if(value)
                    {
                        this.flowStore.nodes = [];
                        this.initialize();
                    }
                });
            },
            download()
            {
                const content = JSON.stringify({
                    builder_version: this.$page.props.ver,
                    uuid           : this.aa_link,
                    node_data      : this.flowStore.nodes,
                });
                const data    = document.createElement('a');
                const file    = new Blob([content], { type: 'text/plain' });

                data.href     = URL.createObjectURL(file);
                data.download = 'CallFlow.json';
                data.click();
            },
            saveCallTree()
            {
                this.activeNode.active = false;
                this.activeNode = {};

                let formData = this.$inertia.form({
                    node_data: this.flowStore.nodes,
                });

                if(this.aa_link)
                {
                    formData.put(route('AutoAttendantBuilderModule.update', this.aa_link), {
                        onError: (err) => alert(err),
                    });
                }
                else
                {
                    formData.post(route('AutoAttendantBuilderModule.store'), {
                        onError: (err) => alert(err),
                    });
                }
            }
        },
    }
</script>
