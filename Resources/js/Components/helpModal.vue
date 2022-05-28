<template>
    <b-modal ref="help-modal" title="Help" ok-only>
        <div v-html="helpText"></div>
    </b-modal>
</template>

<script>
    export default {
        props: {
            // helpText: {
            //     type:    String,
            //     default: null,
            // }
        },
        data() {
            return {
                //
                helpText: null,
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
            openModal(helpText)
            {
                this.helpText = helpText;
                this.$refs['help-modal'].show();
            }
        },
    }
</script>
