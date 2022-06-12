<template>
    <div>
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
</template>

<script>
    import guest from '../../../../../resources/js/Layouts/guest';
    import Layout from '../Template/Layout.vue';

    import Vue         from 'vue';
    import upperFirst  from 'lodash/upperFirst';
    import camelCase   from 'lodash/camelCase';

    //  Module Functions
    import { NewNode, DefaultIncomingLineData } from '../Modules/defaultData';

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
        layout: [ guest, Layout ],
        props: {
            //
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
            this.buildStep('incoming-lines-wizard', new NewNode(-1, 'incoming-lines', new DefaultIncomingLineData));
        },
        mounted() {
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            /**
             * Build the Step Prop for the next step
             */
            buildStep(component, node, data)
            {
                //  If there is a node included in the step, we must assign it an ID
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
                this.activeStep   = newStep;
                this.wizComponent = component;
            },
            /**
             * Get the next step information from the current finished step and use that
             * to build the next step
             */
            nextStep(data)
            {
                this.activeStep.nextStep = data;

                //  Steps may fork into multiple steps.  Use array to manage them
                let next = data.shift();
                this.buildStep(next.component, next.node, next.data);
            },
            /**
             * The end of the Wizard for this line of steps has been reached
             * Check other steps to see if there are any remaining next steps
             */
            endOfLine()
            {
                for(let i = this.progress.length - 1; i >= 0; i--)
                {
                    if(this.progress[i].nextStep && this.progress[i].nextStep.length)
                    {
                        let next = this.progress[i].nextStep.shift();
                        this.buildStep(next.component, next.node, next.data);
                        break;
                    }

                    //  No steps left, build the AA Tree Nodes
                    if(i === 0)
                    {
                        this.buildStep('buildNodes', {}, this.progress);
                    }
                }
            }
        },
    }
</script>
