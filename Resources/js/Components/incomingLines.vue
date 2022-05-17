<template>
    <b-card
        border-variant="dark"
        :header="headerText"
        align="center"
        class="pointer"
    >
        <b-card-text></b-card-text>
    </b-card>
</template>

<script>
    export default {
        props: {
            headerText: {
                type: String,
                default: "Incoming Phone Numbers"
            }
        },
        data() {
            return {
                lineList: [],
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
        },
    }
</script>
