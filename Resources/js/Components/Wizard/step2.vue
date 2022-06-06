<template>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <p>
                Do you want a single greeting to play 24/7 or should there be different greetings
                for when you are open and when you are closed?
            </p>
            <b-button variant="info" pill @click="save('greeting')">One Greeting</b-button>
            <b-button variant="info" pill @click="save('schedule')">Open and Closed Greetings</b-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            //
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
            save(nextStep)
            {
                let nextNode;

                switch (nextStep)
                {
                    case 'greeting':
                        nextNode = this.createGreetingNode();
                        break;
                    case 'schedule':
                        nextNode = this.createScheduleNode();
                        break;
                }

                this.$emit('nextNode', nextNode);
            },
            /**
             * Build the default schedule node
             */
            createScheduleNode()
            {
                return [{
                    nodeType: 'schedule',
                    data: {
                        headerText: 'Business Hours',
                        schedule  : [
                            {
                                start_time: '08:00',
                                stop_time : '17:00',
                                days      : ['mon', 'tue', 'wed', 'thu', 'fri'],
                            }
                        ]
                    }
                }];
            },
            /**
             * Build the default greeting nodes
             */
            createGreetingNode()
            {
                return [
                    {
                        nodeType: 'greeting',
                        data: {
                            headerText      : '24/7 Greeting',
                            greeting        : '',
                            availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                        }
                    }
                ]
            }
        },
    }
</script>
