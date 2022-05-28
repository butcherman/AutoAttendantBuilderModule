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
                // text: this.schedule.title,
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
                this.eventHub.$emit('schedule-click', {nodeId: this.nodeId, data: this.schedule});
            }
        },
    }
</script>
