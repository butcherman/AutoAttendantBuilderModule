<template>
    <div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6 text-center">
                <h3>{{activeStep.data.headerText}}</h3>
                <p>
                    Now lets determine what the Auto Attendant {{activeStep.data.headerText}}
                    should say. Please enter the script for the greeting below.
                    It should include all instructions that a caller will need
                    in order to have their call routed properly.
                </p>
                <p>
                    For example, if you wish to have a way for the callers to
                    reach the Sales department, include "Please press 3 for Sales"
                    or something similar.
                </p>
                <p>
                    If you are not sure where to start, click on the "Sample Greeting"
                    button and a simple greeting that you can modify to fit your
                    needs will populate in the script.
                </p>
            </div>
        </div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6">
                <greeting-form
                    :greetingTitle="activeStep.data.headerText"
                    :greeting="activeStep.data.greeting"
                    saveText="Next"
                    hideHeader
                    @save="save"
                ></greeting-form>
            </div>
        </div>
    </div>
</template>

<script>
    import GreetingForm from '../Forms/greetingForm.vue'
    import { useFlowStore } from '../../Stores/flowStore';
    import { mapStores } from 'pinia';

    export default {
        components: { GreetingForm },
        props: {
            activeStep: {
                type    : Object,
                required: true,
            }
        },
        computed: {
            ...mapStores(useFlowStore),
        },
        methods: {
            save(data)
            {
                this.activeStep.data.greeting = data.greeting;

                let newNode = this.flowStore.buildNode(this.activeStep.parentId, 'greeting', this.activeStep.data);

                let nextStep = [
                    {
                        component: 'dial-options-wizard',
                        data     : { greeting: data.greeting },
                        parentId : newNode.id,
                    }
                ];

                this.activeStep.nextStep = nextStep;
                this.activeStep.nodeId   = newNode.id;

                this.$emit('nextStep');
            },
        },
    }
</script>
