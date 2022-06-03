<template>
    <b-card
        :bg-variant="node.valid ? 'success' : 'warning'"
        align="center"
        class="pointer"
        :class="node.active ? 'active-node' : ''"
        @click="emitClick"
    >
        <b-card-text>{{node.data.headerText}}</b-card-text>
    </b-card>
</template>

<script>
    export default {
        props: {
            node: {
                type: Object,
                required: true,
            }
        },
        methods: {
            emitClick()
            {
                this.eventHub.$emit('flow-component-click', this.node);
            }
        },
    }
</script>
