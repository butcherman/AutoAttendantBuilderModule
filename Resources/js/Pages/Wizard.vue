<template>
    <div class="row h-100">
            <div class="col-12 h-100 overflow-scroll">
                <Transition name="swipe" mode="out-in">
                    <component
                        :is="flowStore.activeStep.component"
                        :activeStep="flowStore.activeStep"
                        @nextStep="nextStep"
                        @endOfLine="endOfLine"
                    ></component>
                </Transition>
            </div>
        </div>
</template>

<script>
    require('../validateRules');

    import guest                       from '../../../../../resources/js/Layouts/guest';
    import Layout                      from '../Template/Layout.vue';

    import { useFlowStore }            from '../Stores/flowStore';
    import { mapStores }               from 'pinia';
    import { DefaultIncomingLineData } from '../Modules/defaultData';

    import Vue                        from 'vue';
    import upperFirst                 from 'lodash/upperFirst';
    import camelCase                  from 'lodash/camelCase';

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
        data() {
            return {
                wizComponent: 'incoming-lines-wizard',
            }
        },
        mounted() {
            this.initialize();
        },
        computed: {
            ...mapStores(useFlowStore),
        },
        methods: {
            initialize()
            {
                let defaultData = new DefaultIncomingLineData;
                this.flowStore.buildWizardStep('incoming-lines-wizard', defaultData, -1);
            },
            nextStep()
            {
                if(this.flowStore.activeStep.nextStep.length)
                {
                    let next = this.flowStore.activeStep.nextStep.shift();
                    this.flowStore.buildWizardStep(next.component, next.data, next.parentId);
                    this.flowStore.stepIndex++;
                }
                else
                {
                    for(let i = this.flowStore.steps.length -1; i >= 0; i--)
                    {
                        if(this.flowStore.steps[i].nextStep.length)
                        {
                            let next = this.flowStore.steps[i].nextStep.shift();

                            this.flowStore.buildWizardStep(next.component, next.data, next.parentId);
                            this.flowStore.stepIndex++;
                            break;
                        }
                        else if(i === 0)
                        {
                            this.endOfLine();
                        }
                    }
                }
            },
            endOfLine()
            {
                this.flowStore.buildWizardStep('wrap-it-up', {}, 99);
                this.flowStore.validateAllnodes();
                this.flowStore.stepIndex++;

                let formData = this.$inertia.form({
                    node_data: this.flowStore.nodes,
                });

                formData.post(route('AutoAttendantBuilderModule.store'), {
                    onError  : (err) => alert(err),
                    onSuccess: () => {
                        this.flowStore.steps = [];
                        this.flowStore.stepIndex = 0;
                    },
                });
            }
        },
    }
</script>
