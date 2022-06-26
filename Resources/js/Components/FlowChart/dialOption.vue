<template>
    <flow-template :node="node" hideSlot />
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
