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
        <ValidationObserver v-slot="{ handleSubmit }" ref="lineForm">
            <b-form @submit.prevent="handleSubmit(save)" @reset.prevent="reset" novalidate>
                <div v-for="(num, key) in form.number" :key="key" class="mb-2">
                    <ValidationProvider v-slot="v" :rules="`${key === 0 ? 'required' : ''}|unique-phone-number:${form.number}`" mode="eager">
                        <vue-phone-number-input v-model="form.number[key]" no-country-selector></vue-phone-number-input>
                        <b-form-invalid-feedback :state="false" v-for="error in v.errors" :key="error">{{error}}</b-form-invalid-feedback>
                    </ValidationProvider>
                </div>
                <div class="clearfix">
                    <b-button size="sm" pill class="float-right" variant="info" @click="form.number.push('')"><i class="fas fa-plus d-none d-sm-inline"></i> Add</b-button>
                </div>
                <div class="text-center">
                    <b-button class="w-25" variant="success" type="submit">{{saveText}}</b-button>
                    <b-button variant="danger"  type="reset" @click="reset" v-if="!hideReset">Reset</b-button>
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
            lineList: {
                type:     Array,
                required: true,
            },
            saveText: {
                type: String,
                required: false,
                default: 'save',
            },
            hideReset: {
                type: Boolean,
                required: false,
                default: false,
            },
        },
        data() {
            return {
                form: {
                    number: [...this.lineList],
                }
            }
        },
        methods: {
            save()
            {
                //  Remove any blank entries
                var newLines = [];
                this.form.number.forEach(num => {
                    if(num !== null)
                    {
                        newLines.push(num);
                    }
                });

                this.$emit('save', { lineList: newLines });
            },
            reset()
            {
                this.form.number = [...this.lineList];
            },
        },
    }
</script>
