<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="text-center text-dark">Lets get started!</h3>
                <p class="text-center">
                    The first bit of information that we will need, is to know what phone numbers are supposed to ring into this Auto Attendant.  Each
                    incoming phone number that will be answered by the AA should be listed here.  To add additional numbers, use the Add button.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <incoming-lines-form
                    :lineList="lineList"
                    hideReset
                    showBack
                    saveText="Next"
                    @save="save"
                    @back="back"
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
                lineList: ['', '', ''],
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
                this.activeStep.node.data.headerText = 'Incoming Phone Lines';

                let nextStep = [
                    {
                        component: 'ask-for-schedule',
                        data: {},
                    }
                ];

                this.$emit('nextStep', nextStep);
            },
            back()
            {
                alert('back...');
            }
        },
    }
</script>
