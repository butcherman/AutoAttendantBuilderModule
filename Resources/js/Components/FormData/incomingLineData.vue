<template>
    <div>
        <h4 class="text-center text-dark">
            Enter the Incoming Phone Numbers
            <i class="far fa-question-circle pointer" title="Help" v-b-tooltip.hover v-b-modal.help-modal></i>
        </h4>
        <b-modal id="help-modal" title="Help" ok-only>
            <p>Enter each incoming phone number that will be answered by this Auto Attendant</p>
            <p>We will need the full area code and number for each phone number that will ring into the AA</p>
            <p>You must enter at least one phone number to continue</p>
        </b-modal>
        <ValidationObserver v-slot="{handleSubmit}" ref="lineForm">
            <b-form @submit.prevent="handleSubmit(save)" @reset.prevent="reset" novalidate>
                <div v-for="(num, key) in form.number" :key="key" class="mb-2">
                    <ValidationProvider v-slot="v" :rules="key == 0 ? 'required' : null" mode="lazy">
                        <vue-phone-number-input v-model="form.number[key]" no-country-selector></vue-phone-number-input>
                        <b-form-invalid-feedback :state="false">{{v.errors[key]}}</b-form-invalid-feedback>
                    </ValidationProvider>
                </div>
                <div class="clearfix">
                    <b-button size="sm" pill class="float-right" variant="info" @click="form.number.push('')"><i class="fas fa-plus d-none d-sm-inline" aria-hidden="true"></i> Add</b-button>
                </div>
                <div class="text-center">
                    <b-button pill variant="success" type="submit">Save</b-button>
                    <b-button pill variant="danger"  type="reset">Reset</b-button>
                </div>
            </b-form>
        </ValidationObserver>
    </div>
</template>

<script>
    import VuePhoneNumberInput from 'vue-phone-number-input';

    export default {
        components: { VuePhoneNumberInput },
        props: {
            nodeId: {
                type:     Number,
                required: true,
            },
            lineList: {
                type:     Array,
                required: true,
            }
        },
        data() {
            return {
                submitted: false,
                form: {
                    number: [''],
                }
            }
        },
        created() {
            //
        },
        mounted() {
            this.reset();
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            /**
             * Save the inputted data to the flow chart
             */
            save()
            {
                //  Break the reactive state that causes updates to push back into props
                var newLines = [];
                this.form.number.forEach(num => {
                    if(num !== null)
                    {
                        newLines.push(num);
                    }
                });

                var saveData = {
                    nodeId  : this.nodeId,
                    valid   : true,
                    lineList: newLines,
                }
                this.$emit('save', {nodeId: this.nodeId, data: saveData});
                this.$emit('changeButtons', {allowSchedule: true, allowGreeting: true, allowOption: false});
            },
            /**
             * Reset the form back to its original state
             */
            reset()
            {
                this.form.number = [];

                this.lineList.forEach(num => {
                    this.form.number.push(num);
                });
            }
        },
    }
</script>
