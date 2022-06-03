<template>
    <b-card
        :header-bg-variant="node.valid ? 'success' : 'warning'"
        bg-variant="light"
        :header="node.data.headerText"
        align="center"
        class="pointer"
        :class="node.active ? 'active-node' : ''"
        @click="emitClick"
    >
        <b-card-text>
            <slot />
        </b-card-text>
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
