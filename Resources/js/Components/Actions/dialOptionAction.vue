<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Option</b-button>
        <b-button v-if="num !== 11" pill variant="danger" @click="remove">Delete Option</b-button>
        <b-modal ref="form-modal" id="form-modal" title="One Key Options" hide-footer>
            <dial-option-form
                :num="num"
                :verbage="verbage"
                :availableOptions="availableOptions"
                @save="save"
            ></dial-option-form>
        </b-modal>
    </div>
</template>

<script>
    import dialOptionForm from '../Forms/dialOptionForm.vue';

    export default {
        components: { dialOptionForm },
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
            remove()
            {
                this.$emit('deleteNode');
            },
            save(data)
            {
                console.log(data);

                //  Update the dialed option and repopulate available options
                if(data.dialOption !== data.wasOption)
                {
                    this.eventHub.$emit('dial-option-changed', {
                        wasOption: data.wasOption,
                        newOption: data.dialOption,
                    });
                }



                //  Determine the proper child to add to the flow chart
            }
        },
    }
</script>
