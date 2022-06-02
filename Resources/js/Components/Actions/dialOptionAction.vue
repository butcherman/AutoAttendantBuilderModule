<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Option</b-button>
        <b-button v-if="node.data.num !== 11" pill variant="danger" @click="remove">Delete Option</b-button>
        <b-modal ref="form-modal" id="form-modal" title="One Key Options" hide-footer>
            <dial-option-form
                :num="node.data.num"
                :verbage="node.data.verbage"
                :whatHappens="node.data.whatHappens"
                :availableOptions="[...node.data.availableOptions]"
                @save="saveData"
            ></dial-option-form>
        </b-modal>
    </div>
</template>

<script>
    import dialOptionForm from '../Forms/dialOptionForm.vue'
    export default {
        components: { dialOptionForm },
        props: {
            node: {
                type: Object,
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
            isValid()
            {
                return this.node.valid;
            }
        },
        watch: {
            /**
             * If we move to another similar component, we need to see if we should open the form again
             */
            isValid(val)
            {
                if(val === false)
                {
                    this.$refs['form-modal'].show();
                }
            }
        },
        methods: {
            remove()
            {
                console.log('remove node');
            },
            saveData(data)
            {
                if(data.num !== data.wasOption)
                {
                    let index = this.node.data.availableOptions.indexOf(data.num);
                    this.node.data.availableOptions.splice(index, 1, data.wasOption).sort((a, b) => {return a - b});
                }

                this.node.valid                = true;
                this.node.data.num             = data.num;
                this.node.data.whatHappens     = data.whatHappens;
                this.node.data.targetExtension = data.targetExtension;

                //  TODO - create child node

                this.$refs['form-modal'].hide();
            }
        },
    }
</script>
