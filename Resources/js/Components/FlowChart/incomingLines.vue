<template>
    <b-card
        border-variant="dark"
        :header-bg-variant="valid ? 'success' : 'warning'"
        :header="headerText"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text>
            <div v-for="number in lineList" :key="number">{{number}}</div>
        </b-card-text>
    </b-card>
</template>

<script>
    export default {
        props: {
            nodeId: {
                type: Number,
                required: true,
            },
            valid: {
                type: Boolean,
                required: true,
            },
            hasChildren: {
                type: Boolean,
                required: true,
            },
            headerText: {
                type: String,
                default: 'Incoming Phone Lines'
            },
            lineList: {
                type: Array,
                required: true,
            },
        },
        methods: {
            emitClick()
            {
                this.eventHub.$emit('flow-component-click', {
                    nodeId         : this.nodeId,
                    actionComponent: 'incoming-line-action',
                });
            }
        },
    }
</script>
