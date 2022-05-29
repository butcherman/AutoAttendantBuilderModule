<template>
    <b-card
        border-variant="dark"
        align="center"
        class="pointer"
        :bg-variant="valid ? 'success' : 'info'"
        @click="emitClick"
    >
        <b-card-text>
            {{title}}
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
            valid: {
                type: Boolean,
                required: true,
            },
            title: {
                type: String,
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
                this.eventHub.$emit('dial-option-click', {
                    nodeId  : this.nodeId,
                    option  : this.title,
                });
            }
        },
    }
</script>
