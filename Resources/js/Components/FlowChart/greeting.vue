<template>
    <b-card
        border-variant="dark"
        :header-bg-variant="valid ? 'success' : 'info'"
        :header="greetingTitle"
        align="center"
        class="pointer"
        @click="emitClick"
    >
        <b-card-text>
            <p>Greeting data...</p>
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
            greetingTitle: {
                type: String,
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
                // headerText: 'On Hours Greeting',
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
                //
                console.log('click');
            }
        },
    }
</script>
