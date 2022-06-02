<template>
    <b-card
        :border-variant="node.active ? 'info' : 'dark'"
        bg-variant="success"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text>{{node.data.text}}</b-card-text>
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
