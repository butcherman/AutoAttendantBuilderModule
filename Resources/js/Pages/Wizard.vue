<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <h2 class="text-center">Auto Attendant Builder</h2>
            </div>
        </div>
        <div id="wizard-wrapper" class="row justify-content-center p-4">
            <div class="col h-100">
                <div class="card h-100">
                    <div class="card-body h-100" style="overflow-y: scroll">
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
                        <div class="row h-100">
                            <div class="col-12">
                                <h3 class="text-center text-dark mt-2 mb-1">Step {{step}}</h3>
                                <Transition name="swipe" mode="out-in">
                                    <component
                                        :is="wizComponent"
                                        :node="activeNode"
                                        @nextStep="nextStep"
                                        @nextNode="nextNode"
                                        @buildGreetOptions="buildGreetOptions"
                                    ></component>
                                </Transition>
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
    import upperFirst  from 'lodash/upperFirst';
    import camelCase   from 'lodash/camelCase';

    /**
     * Register all wizard components
     */
    const requireComponent = require.context('../Components', true, /(Wizard)\/[A-Za-z-0-9]\w+\.vue$/);
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
                step: 1,
                idIndex: 0,
                wizComponent: 'step1',
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
                headerText: 'Incoming Phone Lines',
                lineList: ['', '', ''],
            }, true);
        },
        computed: {
            // wizComponent()
            // {
            //     return 'step'+this.step;
            // }
        },
        watch: {
            //
        },
        methods: {
            /**
             * Create a new Flow Chart Node
             */
            createNode(parentId, nodeComponent, data, setActive = false)
            {
                let newNode = {
                    id: this.idIndex++,
                    parentId,
                    nodeComponent,
                    data,
                    valid      : false,
                    active     : false,
                    hasChildren: false,
                };

                this.nodes.push(newNode);
                if(setActive)
                {
                    this.activeNode = newNode;
                }

                if(parentId >= 0)
                {
                    let parentNode = this.nodes.find(node => node.id === parentId);
                    parentNode.hasChildren = true;
                }
            },
            /**
             * Set the active node of the current step
             */
            setActiveNode(node)
            {
                this.activeNode = node;
            },
            nextStep(next, updateStep = true)
            {
                if(updateStep)
                {
                    this.step++;
                }
                this.wizComponent = next
            },
            nextNode(next)
            {
                let newActive = next[0];

                for(let n of next)
                {
                    this.createNode(this.activeNode.id, n.nodeType, n.data);

                }

                this.activeNode = newActive;
                this.step++;
                this.wizComponent = newActive.nodeType;
            },
            /**
             * Build nodes for each of the one key options
             */
            buildGreetOptions(data)
            {
                // console.log(data);

                this.wizComponent = 'dialOption';
            }
        },
    }
</script>

<style>
    #wizard-wrapper {
        color: #000000;
        height: calc(100vh - 75px);
        overflow: auto;
    }

    .swipe-enter-active,
    .swipe-leave-active {
        transition: all 0.5s ease-out;
    }

    .swipe-enter-from {
        opacity: 0;
        transform: translateX(100px);
    }

    .swipe-leave-to {
        opacity: 0;
        transform: translateX(-100px);
    }
</style>
