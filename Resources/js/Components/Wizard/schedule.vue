<template>
    <div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6 text-center">
                <p>Tell us about your business schedule.  Anything in between the hours noted is considered your
                    On Hours or Open Hours.  All other times are considered your Off Hours, or Closed Hours.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <schedule-form
                    :headerText="node.data.headerText"
                    :schedule="node.data.schedule"
                    saveText="Next"
                    @save="save"
                ></schedule-form>
            </div>
        </div>
    </div>
</template>

<script>
    import scheduleForm from '../Forms/scheduleForm.vue'
    export default {
        components: { scheduleForm },
        props: {
            node: {
                type: Object,
                required: false,
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
            save(data)
            {
                this.node.valid           = true;
                this.node.data.headerText = data.headerText;
                this.node.data.schedule   = data.schedule;

                let nextNode = this.buildGreetingNodes();
                this.$emit('nextNode', nextNode);
            },
            buildGreetingNodes()
            {
                return [
                    {
                        nodeType: 'greeting',
                        data: {
                            headerText      : 'On Hours Greeting',
                            greeting        : '',
                            availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                        }
                    },
                    {
                        nodeType: 'greeting',
                        data: {
                            headerText      : 'Off Hours Greeting',
                            greeting        : '',
                            availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                        }
                    },
                ]
            }
        },
    }
</script>
