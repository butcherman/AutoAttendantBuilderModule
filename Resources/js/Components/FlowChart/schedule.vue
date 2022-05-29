<template>
    <b-card
        border-variant="dark"
        align="center"
        class="pointer"
        :bg-variant="valid ? 'success' : 'info'"
        @click="emitClick"
    >
        <b-card-text>
            {{schedule.title}}
        </b-card-text>
    </b-card>
</template>

<script>
    export default {
        props: {
            nodeId: {
                type: Number,
                required: true,
            },
            schedule: {
                type: Object,
                default: () => {},
            },
            valid: {
                type: Boolean,
                required: true,
            }
        },
        data() {
            return {
                //
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
                this.eventHub.$emit('change-buttons', {allowSchedule: false, allowGreeting: false, allowOption: false});
                this.eventHub.$emit('schedule-click', {nodeId: this.nodeId, data: this.schedule});
            }
        },
    }
</script>
