<template>
    <b-card
        border-variant="dark"
        align="center"
        class="pointer"
        :bg-variant="valid ? 'success' : 'warning'"
        @click="emitClick"
    >
        <b-card-text>
            {{verbage}} {{num !== 11 ? num : ''}}
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
            num: {
                type: Number|String,
                required: true,
            },
            verbage: {
                type: String,
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
                this.eventHub.$emit('flow-component-click', {
                    nodeId         : this.nodeId,
                    actionComponent: 'dial-option-action',
                });
            }
        },
    }
</script>
