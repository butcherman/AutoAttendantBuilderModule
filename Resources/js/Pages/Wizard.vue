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
                        <div class="row h-100">
                            <div class="col-12 h-100 overflow-scroll">
                                <Transition name="swipe" mode="out-in">
                                    <component
                                        :is="wizComponent"
                                        :activeStep="activeStep"
                                        @nextStep="nextStep"
                                        @endOfLine="endOfLine"
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

    import { NewNode } from '../Modules/defaultData';

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
                stepId: 0,
                nodeId: 0,
                wizComponent: 'incomingLinesWizard',
                activeStep: {},
                progress: [],
            }
        },
        created() {
            //
        },
        mounted() {
            //
            this.buildStep('incoming-lines-wizard', new NewNode(-1, 'incoming-lines', {}));
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            buildStep(component, node, data)
            {
                if(node)
                {
                    node.id = this.nodeId++;
                }

                let newStep = {
                    id: this.stepId++,
                    component,
                    node,
                    data,
                }

                this.progress.push(newStep);
                this.setActiveStep(newStep);
                this.wizComponent = component;
            },
            setActiveStep(node)
            {
                this.activeStep = node;
            },
            nextStep(data)
            {
                this.activeStep.nextStep = data;

                let next = data.shift();
                console.log(next);
                this.buildStep(next.component, next.node, next.data);
            },
            endOfLine()
            {
                console.log('end of the line');

                for(let i = this.progress.length - 1; i >= 0; i--)
                {
                    if(this.progress[i].nextStep && this.progress[i].nextStep.length)
                    {
                        let next = this.progress[i].nextStep.shift();
                        console.log(next);
                        this.buildStep(next.component, next.node, next.data);
                        break;
                    }

                    if(i === 0)
                    {
                        this.buildStep('buildNodes', {}, this.progress);
                    }
                }
            }
        },
    }
</script>
