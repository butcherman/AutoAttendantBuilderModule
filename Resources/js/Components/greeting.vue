<template>
    <b-card
        border-variant="dark"
        header="Main Greeting"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text>
            <p>Greeting goes here</p>
        </b-card-text>
    </b-card>
</template>

<script>
    export default {
        props: {
            //
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
            //
            emitClick()
            {
                this.eventHub.$emit('greeting-click', {nodeId: this.nodeId, data: {}});
            }
        },
    }
</script>
