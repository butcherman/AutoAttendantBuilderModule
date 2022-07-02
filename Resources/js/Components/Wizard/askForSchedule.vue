<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h3>Do you want multiple greetings?</h3>
                <p>
                    Do you want a single greeting to play 24/7 or should there
                    be different greetings for when you are open and when you
                    are closed?
                </p>
                <b-button
                    class="w-50 m-2"
                    variant="info"
                    @click="choose('greeting')"
                >
                    One Greeting 24/7
                </b-button>
                <b-button
                    class="w-50 m-2"
                    variant="info"
                    @click="choose('schedule')"
                >
                    Open and Closed Greetings
                </b-button>
            </div>
        </div>
    </div>
</template>

<script>
    import { DefaultScheduleData, DefaultGreetingData } from '../../Modules/defaultData';

    export default {
        props: {
            activeStep: {
                type: Object,
                required: true,
            }
        },
        methods: {
            choose(choice)
            {
                let nextStep = [];
                let defaultData;

                if(choice === 'greeting')
                {
                    defaultData            = new DefaultGreetingData;
                    defaultData.headerText = '24/7 Greeting';
                }
                else if(choice === 'schedule')
                {
                    defaultData = new DefaultScheduleData;
                }

                nextStep.push({
                    component: `${choice}-wizard`,
                    data     : defaultData,
                    parentId : this.activeStep.parentId,
                });

                this.activeStep.nextStep = nextStep;

                this.$emit('nextStep');
            },
        },
    }
</script>
