<template>
    <div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6 text-center">
                <p>
                    Tell us about your business schedule.  Anything in between the hours noted is considered your
                    On Hours or Open Hours.  All other times are considered your Off Hours, or Closed Hours.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <schedule-form
                    :headerText="activeStep.node.data.headerText"
                    :schedule="schedule"
                    saveText="Next"
                    hideReset
                    showBack
                    @save="save"
                    @back="back"
                ></schedule-form>
            </div>
        </div>
    </div>
</template>

<script>
    import ScheduleForm from '../Forms/scheduleForm.vue';
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
        created() {
            //
        },
        mounted() {
            //
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            save(data)
            {
                this.activeStep.node.data = data;

                let greetings = ['On Hours Greeting', 'Off Hours Greeting'];
                let nextStep = [];

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
            back()
            {
                console.log('back');
                alert('go back....');
            }
        },
    }
</script>
