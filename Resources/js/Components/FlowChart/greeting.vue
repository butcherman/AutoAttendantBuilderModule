<template>
    <b-card
        border-variant="dark"
        :header-bg-variant="valid ? 'success' : 'info'"
        :header="greetingTitle"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text v-html="greeting"></b-card-text>
    </b-card>
</template>

<script>
    export default {
        props: {
            nodeId: {
                type: Number,
                required: true,
            },
            greetingTitle: {
                type: String,
                required: true,
            },
            greeting: {
                type: String,
                required: true,
            },
            valid: {
                type: Boolean,
                required: true,
            },
            usedOption: {
                type: Array,
                default: () => [],
            }
        },
        data() {
            return {
                //
                // headerText: 'On Hours Greeting',
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
            emitClick()
            {
                this.eventHub.$emit('change-buttons', {allowSchedule: false, allowGreeting: false, allowOption: true});
                this.eventHub.$emit('greeting-click', {
                    nodeId  : this.nodeId,
                    title   : this.greetingTitle,
                    greeting: this.greeting
                });
            }
        },
    }
</script>
