<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <p>
                    Do you want a single greeting to play 24/7 or should there be different greetings
                    for when you are open and when you are closed?
                </p>

                <b-button variant="info" pill @click="choose('greeting')">One Greeting 24/7</b-button>
                <b-button variant="info" pill @click="choose('schedule')">Open and Closed Greetings</b-button>
            </div>
        </div>
        <div class="row justify-content-center mt-4">
            <div class="col-md-6 text-center">
                <b-button variant="info" pill @click="back">Back</b-button>
            </div>
        </div>
    </div>
</template>

<script>
    import { NewNode, DefaultScheduleData, DefaultGreetingData } from '../../Modules/defaultData';

    export default {
        props: {
            activeStep: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                //
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
            choose(choice)
            {
                let nextStep = [];

                if(choice === 'greeting')
                {
                    let defaultData = new DefaultGreetingData;
                    defaultData.headerText = '24/7 Greeting';

                    nextStep.push({
                        component: 'greeting-wizard',
                        node: new NewNode(0, 'greeting', defaultData),
                    });
                }
                else if(choice === 'schedule')
                {
                    nextStep.push({
                        component: 'schedule-wizard',
                        node: new NewNode(0, 'schedule', new DefaultScheduleData),
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
