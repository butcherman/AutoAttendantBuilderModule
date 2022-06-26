<template>
    <div>
        <h4 v-if="!hideHeader" class="text-center text-dark">
            Enter the Incoming Phone Numbers
            <i
                title="Help"
                class="far fa-question-circle pointer"
                v-b-tooltip.hover
                v-b-modal.help-modal
            />
        </h4>
        <b-modal id="help-modal" title="Help" ok-only>
            <p>
                Enter each incoming phone number that will be answered by this
                Auto Attendant.
            </p>
            <p>
                We will need the full area code and number for each phone number
                that will ring into the AA.
            </p>
            <p>
                You must enter at least one phone number to continue
            </p>
        </b-modal>
        <ValidationObserver v-slot="{ handleSubmit }" ref="lineForm">
            <b-form
                novalidate
                @submit.prevent="handleSubmit(save)"
                @reset.prevent="reset"
            >
                <div
                    v-for="(num, key) in form.number"
                    :key="key"
                    class="mb-2"
                >
                    <ValidationProvider
                        v-slot="v"
                        :rules="`${key === 0 ? 'required' : ''}|unique-phone-number:${form.number}`"
                        mode="eager"
                    >
                        <vue-phone-number-input
                            v-model="form.number[key]"
                            no-country-selector
                        />
                        <b-form-invalid-feedback :state="false">
                            {{v.errors[0]}}
                        </b-form-invalid-feedback>
                    </ValidationProvider>
                </div>
                <div class="clearfix">
                    <b-button
                        size="sm"
                        pill
                        class="float-right"
                        variant="info"
                        @click="form.number.push('')"
                    >
                        <i class="fas fa-plus d-none d-sm-inline" /> Add
                    </b-button>
                </div>
                <div class="text-center">
                    <b-button
                        class="w-25"
                        type="submit"
                        variant="success"
                    >
                        {{saveText}}
                    </b-button>
                    <b-button
                        class="w-25"
                        type="reset"
                        variant="danger"
                    >
                        Reset
                    </b-button>
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
                type    : Array,
                required: true,
            },
            saveText: {
                type   : String,
                default: 'save',
            },
            hideHeader: {
                type   : Boolean,
                default: false,
            }
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
