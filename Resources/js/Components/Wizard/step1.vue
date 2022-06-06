<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <p>
                    The first thing that we need to know is your phone number.
                </p>
                <p>
                    Please enter each phone number that will ring into this Auto Attendant.
                    You must enter at least one number.  To add additional numbers, use the
                    Add button.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 p-4">
                <incoming-lines-form :lineList="['','','']" saveText="Next" @save="save"></incoming-lines-form>
            </div>
        </div>
    </div>
</template>

<script>
    import incomingLinesForm from '../Forms/incomingLinesForm.vue';

    export default {
        components: { incomingLinesForm },
        props: {
            node: {
                type: Object,
                required: true,
            }
        },
        methods: {
            save(data)
            {
                this.node.data.lineList = data.lineList;
                this.node.valid         = true;

                this.$emit('nextStep', 'step2');
            }
        },
    }
</script>
