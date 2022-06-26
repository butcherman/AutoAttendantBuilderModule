<template>
    <div>
        <h4 v-if="!hideHeader" class="text-center text-dark">
            Enter the {{greetingTitle}} Script
            <i
                title="Help"
                class="far fa-question-circle pointer"
                v-b-tooltip.hover
                v-b-modal.help-modal
            />
        </h4>
        <b-modal id="help-modal" title="Help" ok-only>
            <p>
                Type out the script that callers should hear when they reach
                this greeting.
            </p>
            <p>
                If you are not sure where to start, use the <strong>Sample
                Greeting</strong> button for a generic greeting you can modify
                to fit your needs.
            </p>
        </b-modal>
        <ValidationObserver v-slot="{handleSubmit}">
            <b-form
                novalidate
                @submit.prevent="handleSubmit(save)"
                @reset.prevent="reset"
            >
                <text-editor
                    v-model="form.greeting"
                    placeholder="Enter Greeting"
                    label="Greeting Script"
                    rules="required"
                />
                <div class="text-center">
                    <b-button class="w-25" variant="success" type="submit">
                        {{saveText}}
                    </b-button>
                    <b-button class="w-25" variant="danger" type="reset">
                        Reset
                    </b-button>
                </div>
            </b-form>
        </ValidationObserver>
        <div class="text-center m-4">
            <b-button
                class="w-50"
                variant="info"
                @click="enterSample"
            >
                Create Sample Greeting
            </b-button>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            greetingTitle: {
                type    : String,
                required: true,
            },
            greeting: {
                type    : String,
                required: true,
            },
            saveText: {
                type   : String,
                default: 'Save',
            },
            hideHeader: {
                type   : Boolean,
                default: false,
            }
        },
        data() {
            return {
                form: {
                    greeting: this.greeting,
                },
            }
        },
        methods: {
            save()
            {
                this.$emit('save', this.form);
            },
            reset()
            {
                this.form.greeting = this.greeting;
            },
            enterSample()
            {
                const sample = `Hello and thank you for calling ABC Company.  If you know the extension number
                                of the person you are trying to reach, you may enter it at any time.  Press 8
                                for a staff directory, or stay on the line to leave a general message.`;

                this.form.greeting = sample;
            },
        },
    }
</script>
