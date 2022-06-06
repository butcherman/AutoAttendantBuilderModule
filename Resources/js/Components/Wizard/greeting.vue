<template>
    <div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6 text-center">
                <h3 class="text-center text-dark">{{node.data.headerText}}</h3>
                <p>
                    Now lets determine what the Auto Attendant Greeting should say.  Please enter the script
                    for the greeting below.  It should include all instructions that a caller will need in order
                    to have their call routed properly.
                </p>
                <p>
                    For example, if you wish to have a way for the callers to reach the Sales department, include
                    "Please press 3 for Sales" or something similar.
                </p>
                <p>
                    If you are not sure where to start, click on the "Sample Greeting" button and a simple greeting
                    that you can modify to fit your needs will populate in the script.
                </p>
            </div>
        </div>
        <div class="row justify-content-center grid-margin">
            <div class="col-md-6">
                <greeting-form
                    :greetingTitle="node.data.headerText"
                    :greeting="node.data.greeting"
                    saveText="Next"
                    @save="save"
                ></greeting-form>
            </div>
        </div>
    </div>
</template>

<script>
    import greetingForm from '../Forms/greetingForm.vue'

    export default {
        components: { greetingForm },
        props: {
            node: {
                type: Object,
                required: true,
            }
        },
        methods: {
            save(data)
            {
                this.node.valid         = true;
                this.node.data.greeting = data.greeting;

                this.$emit('nextStep', 'dialOption', false);
            },
        },
    }
</script>
