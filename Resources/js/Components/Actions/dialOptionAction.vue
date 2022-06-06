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
        mounted() {
            if(!this.node.valid)
            {
                this.$refs['form-modal'].show();
            }
        },
        computed: {
            nodeId()
            {
                return this.node.id;
            }
        },
        watch: {
            /**
             * If we move to another similar component, we need to see if we should open the form again
             */
            nodeId(newId, oldId)
            {
                if(!this.node.valid)
                {
                    this.$refs['form-modal'].show();
                }
            }
        },
        methods: {
            remove()
            {
                this.$emit('deleteMe');
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

                this.giveBirth(data.whatHappens, data.targetExtension);


                this.$refs['form-modal'].hide();
            },
            giveBirth(toWho, addData = null)
            {
                let defaultData = {};
                let componentType = null;

                switch(toWho)
                {
                    case 'Hang Up':
                    case 'Repeat':
                    case 'Staff Directory':
                        componentType = 'textBlock';
                        defaultData.text = toWho;
                        break;
                    case 'Ring Phone(s)':
                    case 'Take Message':
                        componentType = 'gotoPhones';
                        defaultData.headerText = toWho;
                        defaultData.extList = addData;
                        break;
                    case 'Play Greeting':
                        componentType = 'greeting';
                        defaultData = {
                            headerText      : 'Sub Greeting',
                            greeting        : '',
                            availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                        }
                }

                if(this.node.hasChildren)
                {
                    this.$emit('removeChildren');
                }

                this.$emit('giveBirth', {
                    component: componentType,
                    data     : defaultData
                });
            }
        },
    }
</script>
