<template>
    <b-card
        :header-bg-variant="node.valid ? 'success' : 'warning'"
        :header="node.data.headerText"
        align="center"
        class="pointer"
        :class="node.active ? 'active-node' : ''"
        @click="emitClick"
    >
        <b-card-text v-html="node.data.greeting"></b-card-text>
    </b-card>
</template>

<script>
    import FlowTemplate from '../flowTemplate.vue';

    export default {
        components: { FlowTemplate },
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
