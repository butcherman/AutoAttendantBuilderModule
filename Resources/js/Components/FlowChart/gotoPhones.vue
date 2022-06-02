<template>
    <b-card
        :border-variant="node.active ? 'info' : 'dark'"
        header-bg-variant="success"
        :header="node.data.headerText"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text>
            <div v-for="ext in node.data.extList" :key="ext">{{ext}}</div>
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
