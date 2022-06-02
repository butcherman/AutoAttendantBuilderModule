<template>
    <b-card
        :border-variant="node.active ? 'info' : 'dark'"
        :header-bg-variant="node.valid ? 'success' : 'warning'"
        :bg-variant="node.active ? 'info' : 'light'"
        :header="node.data.headerText"
        align="center"
        class="pointer"
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
        computed: {
            //
        },
        methods: {
            emitClick()
            {
                this.eventHub.$emit('flow-component-click', this.node);
            }
        },
    }
</script>
