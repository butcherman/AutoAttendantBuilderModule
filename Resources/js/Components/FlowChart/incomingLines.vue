<template>
    <flow-template :node="node">
        <div v-for="number in node.data.lineList" :key="number">{{number}}</div>
    </flow-template>
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
    }
</script>
