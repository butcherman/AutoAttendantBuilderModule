<template>
    <div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6 text-center">
                <h3>Business Hours</h3>
                <p>
                    Tell us about your business schedule.  Anything in between the hours you input below are
                    considered your "On Hours" or Open Hours.  All other times are considered your "Off Hours"
                    or Closed Hours.
                </p>
                <p>
                    If you are open different hours on different days, you can use the Add button to generate
                    multiple schedule ranges.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <schedule-form
                    :headerText="activeStep.node.data.headerText"
                    :schedule="schedule"
                    saveText="Next"
                    hideReset
                    hideHeader
                    @save="save"
                ></schedule-form>
            </div>
        </div>
    </div>
</template>

<script>
    import ScheduleForm                     from '../Forms/scheduleForm.vue';
    import { DefaultGreetingData, NewNode } from '../../Modules/defaultData';

    export default {
        components: { ScheduleForm },
        props: {
            activeStep: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                schedule: this.activeStep.node.data.schedule,
            }
        },
        methods: {
            save(data)
            {
                this.activeStep.node.data = data;

                let greetings = ['On Hours Greeting', 'Off Hours Greeting'];
                let nextStep  = [];

                //  Build the On Hours and Off Hours greeting steps
                for(let g of greetings)
                {
                    let defaultData = new DefaultGreetingData;
                    defaultData.headerText = g;

                    nextStep.push({
                        component: 'greeting-wizard',
                        node: new NewNode(this.activeStep.node.id, 'greeting', defaultData),
                    });
                }
                this.$emit('nextStep', nextStep);
            },
        },
    }
</script>
