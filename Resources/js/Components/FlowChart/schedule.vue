<template>
    <b-card
        border-variant="dark"
        align="center"
        class="pointer"
        :bg-variant="valid ? 'success' : 'warning'"
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
            hasChildren: {
                type: Boolean,
                required: true,
            },
            title: {
                type: String,
                required: true,
            }
        },
        methods: {
            emitClick()
            {
                this.eventHub.$emit('flow-component-click', {
                    nodeId         : this.nodeId,
                    actionComponent: 'schedule-action',
                });
            }
        },
    }
</script>
