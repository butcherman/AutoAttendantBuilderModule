<template>
    <flow-template :node="node">
        <div v-html="node.data.greeting" />
    </flow-template>
</template>

<script>
    import FlowTemplate from '../flowTemplate.vue';

    export default {
        components: { FlowTemplate },
        props: {
            node: {
                type    : Object,
                required: true,
            }
        },
    }
</script>
