<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Greeting</b-button>
        <b-button v-if="valid" pill variant="info">Add Dial Option</b-button>
        <b-modal ref="form-modal" id="form-modal" :title="greetingTitle" hide-footer>
            <greeting-form :greetingTitle="greetingTitle" :greeting="greeting" @save="saveData"></greeting-form>
        </b-modal>
    </div>
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
            greetingTitle: {
                type: String,
                required: true,
            },
            greeting: {
                type: String,
                required: true,
            },
            availableOptions: {
                type: Array,
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
            if(!this.valid)
            {
                this.$refs['form-modal'].show();
            }
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            saveData(data)
            {
                console.log(data);
            }
        },
    }
</script>
