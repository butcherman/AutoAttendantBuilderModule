<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h3>Lets get started!</h3>
                <p>
                    The first bit of information that we will need, is to know what phone numbers are supposed to ring into this Auto Attendant.  Each
                    incoming phone number that will be answered by the AA should be listed here.  To add additional numbers, use the Add button.
                </p>
            </div>
        </div>
        <div class="row justify-content-center mt-4 pt-4 border-top">
            <div class="col-md-6">
                <incoming-lines-form
                    :lineList="activeStep.node.data.lineList"
                    hideReset
                    saveText="Next"
                    @save="save"
                ></incoming-lines-form>
            </div>
        </div>
    </div>
</template>

<script>
    import incomingLinesForm   from '../Forms/incomingLinesForm.vue';

    export default {
        components: { incomingLinesForm },
        props: {
            activeStep: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                lineList: [],
            }
        },
        methods: {
            save(data)
            {
                this.activeStep.node.data = data;
                this.activeStep.node.data.headerText = 'Incoming Phone Lines';

                let nextStep = [
                    {
                        component: 'ask-for-schedule',
                        data: {},
                    }
                ];

                this.$emit('nextStep', nextStep);
            },
        },
    }
</script>
