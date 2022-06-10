<template>
    <b-card
        :border-variant="node.active ? 'info' : 'dark'"
        :bg-variant="node.valid ? 'success' : 'warning'"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text>{{node.data.verbage}} {{node.data.num !== 11 ? node.data.num : ''}}</b-card-text>
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
