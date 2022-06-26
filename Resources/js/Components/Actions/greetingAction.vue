<template>
    <div class="text-center">
        <b-button
            variant="info"
            pill
            v-b-modal.form-modal
        >
            Modify Greeting
        </b-button>
        <b-button
            v-if="allowDelete"
            variant="danger"
            pill
            @click="deleteMe"
        >
            Delete Greeting
        </b-button>
        <b-button
            v-if="node.valid"
            variant="info"
            pill
            @click="addDialOption('?', 'Press')"
        >
            Add Dial Option
        </b-button>
        <b-modal
            id="form-modal"
            ref="form-modal"
            :title="node.data.headerText"
            hide-footer
            no-enforce-focus
        >
            <greeting-form
                :greetingTitle="node.data.headerText"
                :greeting="node.data.greeting"
                @save="saveData"
            />
        </b-modal>
    </div>
</template>

<script>
    import { mapStores }         from 'pinia';
    import GreetingForm          from '../Forms/greetingForm.vue';
    import { useFlowStore }      from '../../Stores/flowStore';
    import { findDialOptions }   from '../../Modules/greetingMethods';
    import { DefaultOptionData } from '../../Modules/defaultData';

    export default {
        components: { GreetingForm },
        props: {
            node: {
                type    : Object,
                required: true,
            }
        },
        data() {
            return {
                optCount: 11 - this.node.data.availableOptions.length,
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
            },
            allowDelete()
            {
                return this.node.data.headerText === '24/7 Greeting';
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
            saveData(data)
            {
                this.node.valid        = true;
                this.node.data.greeting = data.greeting;

                let greetOptions = findDialOptions(data.greeting);
                greetOptions.forEach(opt => {
                    let available = this.node.data.availableOptions.indexOf(opt.optNum);
                    if(available >= 0)
                    {
                        this.node.data.availableOptions.splice(available, 1);
                        this.addDialOption(opt.optNum, opt.verbage);
                    }
                });


                this.$refs['form-modal'].hide();
            },
            /**
             * Add a one key dial option to the greeting tree
             */
            addDialOption(num, verbage)
            {
                if(this.optCount <= 10)
                {
                    let defaultData              = new DefaultOptionData;
                    defaultData.headerText       = `${verbage} ${num !== 11 ? num : ''}`
                    defaultData.num              = num;
                    defaultData.verbage          = verbage;
                    defaultData.availableOptions = this.node.data.availableOptions;

                    this.optCount++;
                    this.flowStore.buildNode(this.node.id, 'dialOption', defaultData);
                }
                else
                {
                    this.$bvModal.msgBoxOk('No more one key options available');
                }
            },
            deleteMe()
            {
                this.$emit('delete_me');
            }
        },
    }
</script>
