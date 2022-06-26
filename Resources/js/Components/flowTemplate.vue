<template>
    <b-card
        :no-body="hideSlot"
        :header="node.data.headerText"
        :class="node.active ? 'active-node' : ''"
        :header-bg-variant="node.valid ? 'success' : 'warning'"
        align="center"
        class="pointer"
        bg-variant="light"
        @click="emitClick"
    >
        <b-card-text v-if="!hideSlot">
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
            },
            hideSlot: {
                type: Boolean,
                default: false,
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
