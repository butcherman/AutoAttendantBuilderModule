<template>
    <b-card
        border-variant="dark"
        :header-bg-variant="valid ? 'success' : 'info'"
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
            headerText: {
                type: String,
                default: 'Incoming Phone Numbers'
            },
            nodeId: {
                type: Number,
                required: true,
            },
            lineList: {
                type: Array,
                required: true,
            },
            valid: {
                type: Boolean,
                required: true,
            }
        },
        data() {
            return {
                //
            }
        },
        created() {
            //
        },
        mounted() {
            //
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            emitClick()
            {
                this.eventHub.$emit('incoming-line-click', {
                    nodeId: this.nodeId,
                    data  : this.lineList
                });
            }
        },
    }
</script>
