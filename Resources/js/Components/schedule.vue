<template>
    <b-card
        border-variant="dark"
        align="center"
        class="pointer"
        bg-variant="info"
        @click="emitClick"
    >
        <b-card-text>
            {{text}}
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
            }
        },
        data() {
            return {
                text: this.schedule.title,
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
                console.log('emitting');
                this.eventHub.$emit('schedule-click', {nodeId: this.nodeId, data: this.schedule});
            }
        },
    }
</script>
