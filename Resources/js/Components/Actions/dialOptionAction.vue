<template>
    <div class="text-center">
        <b-button
            variant="info"
            pill
            v-b-modal.form-modal
        >
            Modify Option
        </b-button>
        <b-button
            v-if="node.data.num !== 11"
            pill
            variant="danger"
            @click="remove"
        >
            Delete Option
        </b-button>
        <b-modal
            id="form-modal"
            ref="form-modal"
            title="One Key Options"
            hide-footer
        >
            <dial-option-form
                :num="node.data.num"
                :verbage="node.data.verbage"
                :whatHappens="node.data.whatHappens"
                :availableOptions="node.data.availableOptions"
                @save="saveData"
            ></dial-option-form>
        </b-modal>
    </div>
</template>

<script>
    import { DefaultGreetingData } from '../../Modules/defaultData';
    import dialOptionForm from '../Forms/dialOptionForm.vue'
    import { useFlowStore }  from '../../Stores/flowStore';
    import { mapStores }     from 'pinia';

    export default {
        components: { dialOptionForm },
        props: {
            node: {
                type    : Object,
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
            ...mapStores(useFlowStore),
            nodeId()
            {
                return this.node.id;
            }
        },
        watch: {
            /**
             * If we move to another similar component, we need to see if we should open the form again
             */
            nodeId()
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
                this.$emit('delete_me');
            },
            saveData(data)
            {
                //  If the option changed from what it previously was, we need to update the available list
                if(data.num !== this.node.data.num)
                {
                    console.log('num changed');
                    let index = this.node.data.availableOptions.indexOf(data.num);
                    this.node.data.availableOptions.splice(index, 1);
                    if(this.node.data.num !== '?')
                    {
                        this.node.data.availableOptions.push(this.node.data.num);
                    }
                }

                this.node.valid                = true;
                this.node.data.headerText      = `${this.node.data.verbage} ${data.num !== 11 ? data.num : ''}`
                this.node.data.num             = data.num;
                this.node.data.whatHappens     = data.whatHappens;
                this.node.data.targetExtension = data.targetExtension;

                this.buildNext(data.whatHappens, data.targetExtension);
                this.$refs['form-modal'].hide();
            },
            buildNext(what, target)
            {
                let defaultData;
                let componentType = null;

                switch(what)
                {
                    case 'Hang Up':
                    case 'Repeat':
                    case 'Staff Directory':
                        componentType = 'textBlock';
                        defaultData   = { text: what };
                        break;
                    case 'Ring Phone(s)':
                    case 'Take Message':
                        componentType = 'gotoPhones';
                        defaultData   = {
                            headerText: what,
                            extList   : target,
                        }
                        break;
                    case 'Play Greeting':
                        componentType = 'greeting';
                        defaultData   = new DefaultGreetingData;
                        defaultData.headerText = 'Sub Menu';
                }

                if(this.node.hasChildren)
                {
                    console.log('has children');
                }

                this.flowStore.buildNode(this.node.id, componentType, defaultData);
            }
        },
    }
</script>
