<template>
    <div>
        <h4 class="text-center text-dark">
            Enter the {{greetingTitle}} Script
            <i class="far fa-question-circle pointer" title="Help" v-b-tooltip.hover v-b-modal.help-modal></i>
        </h4>
        <b-modal id="help-modal" title="Help" ok-only>
            <p>Type out the script that callers should hear when they reach this greeting.</p>
            <p>If you are not sure where to start, use the <strong>Sample Greeting</strong> button
            for a generic greeting you can modify to fit your needs.</p>
        </b-modal>
        <ValidationObserver v-slot="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(save)" @reset.prevent="reset" novalidate>
                <text-editor v-model="form.greeting" placeholder="Enter Greeting" label="Greeting Script" rules="required"></text-editor>
                <div class="text-center">
                    <b-button pill variant="info" @click="back" v-if="showBack">Back</b-button>
                    <b-button pill variant="success" type="submit">{{saveText}}</b-button>
                    <b-button pill variant="danger" @click="reset" v-if="!hideReset">Reset</b-button>
                    <b-button pill variant="info" @click="enterSample">Sample Greeting</b-button>
                </div>
            </b-form>
        </ValidationObserver>
    </div>
</template>

<script>
    export default {
        props: {
            greetingTitle: {
                type: String,
                required: true,
            },
            greeting: {
                type: String,
                required: true,
            },
            saveText: {
                type: String,
                required: false,
                default: 'Save',
            },
            hideReset: {
                type: Boolean,
                required: false,
                default: false,
            },
            showBack: {
                type: Boolean,
                required: false,
                default: false,
            }
        },
        data() {
            return {
                form       : {
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
            back()
            {
                this.$emit('back');
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
