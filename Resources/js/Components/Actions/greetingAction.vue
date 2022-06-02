<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Greeting</b-button>
        <b-button v-if="node.valid" pill variant="info" @click="addDialOption('?', 'Press')">Add Dial Option</b-button>
        <b-modal ref="form-modal" id="form-modal" :title="node.data.headerText" hide-footer no-enforce-focus>
            <greeting-form :greetingTitle="node.data.headerText" :greeting="node.data.greeting" @save="saveData"></greeting-form>
        </b-modal>
    </div>
</template>

<script>
    import upperFirst   from 'lodash/upperFirst';
    import GreetingForm from '../Forms/greetingForm.vue';

    export default {
        components: { GreetingForm },
        props: {
            node: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                optCount: 11 - this.node.data.availableOptions.length,
            }
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
            saveData(data)
            {
                let greetOptions = this.findDialOptions(data.greeting);
                greetOptions.forEach(opt => {
                    let available = this.node.data.availableOptions.indexOf(opt.optNum);
                    if(available >= 0)
                    {
                        this.node.data.availableOptions.splice(available, 1);
                        this.addDialOption(opt.optNum, opt.verbage);
                    }
                });

                this.node.valid = true;
                this.node.data.greeting = data.greeting;
                this.$refs['form-modal'].hide();
            },
            /**
             * Add a one key dial option to the greeting tree
             */
            addDialOption(num, verbage)
            {
                if(this.optCount <= 10)
                {
                    this.optCount++;
                    this.$emit('giveBirth', {
                        component: 'dialOption',
                        data: {
                            num,
                            verbage,
                            whatHappens: null,
                            availableOptions: this.node.data.availableOptions,
                            targetExtension: [],
                        }
                    });
                }
                else
                {
                    alert('cannot add any more');
                }
            },
            /**
             * Find any verbage like "Press 1 for..." or "Dial 1 for..." to note a one key dial option
             */
            findDialOptions(greeting)
            {
                const regex  = /(press|dial) \d/gmi;
                let foundOpt = greeting.match(regex);

                //  The default option that is in every AA Tree is time out
                let dialOptions = [
                    {
                        optNum: 11,
                        verbage: 'Time Out',
                    }
                ];

                if(foundOpt != null)
                {
                    foundOpt.forEach(opt => {
                        let number = opt.match(/\d+/);
                        let verbage = opt.match(/(press|dial)/gmi);

                        dialOptions.push({
                            optNum: Number(number[0]),
                            verbage: upperFirst(verbage),
                        });
                    });
                }

                return dialOptions;
            }
        },
    }
</script>
