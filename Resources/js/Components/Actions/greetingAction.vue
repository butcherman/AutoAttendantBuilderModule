<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Greeting</b-button>
        <b-button v-if="valid" pill variant="info" @click="addDialOption('?', 'Press')">Add Dial Option</b-button>
        <b-modal ref="form-modal" id="form-modal" :title="greetingTitle" hide-footer no-enforce-focus>
            <greeting-form :greetingTitle="greetingTitle" :greeting="greeting" @save="saveData"></greeting-form>
        </b-modal>
    </div>
</template>

<script>
    import upperFirst   from 'lodash/upperFirst';
    import greetingForm from '../Forms/greetingForm.vue';

    export default {
        components: { greetingForm },
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
                optionCount: 11 - this.availableOptions.length,
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
                //  Break the reactivity to the available options array
                let newAvailableOptions = [];
                this.availableOptions.forEach(opt => {
                    newAvailableOptions.push(opt);
                });

                let greetOptions = this.findDialOptions(data.greeting);
                greetOptions.forEach(opt => {
                    let available = newAvailableOptions.indexOf(opt.optNum);

                    if(available >= 0)
                    {
                        newAvailableOptions.splice(available, 1);
                        this.addDialOption(opt.optNum, opt.verbage);
                    }
                });

                this.$emit('saveData', {
                    nodeId          : this.nodeId,
                    valid           : true,
                    hasChildren     : this.hasChildren,
                    greetingTitle   : this.greetingTitle,
                    greeting        : data.greeting,
                    availableOptions: newAvailableOptions,
                });
                this.$refs['form-modal'].hide();
            },
            addDialOption(num, verbage)
            {
                if(this.optionCount <= 10)
                {
                    this.optionCount++;
                    this.$emit('giveBirth', {
                        type: 'dial-option',
                        data: {
                            num: num,
                            verbage: verbage,
                            availableOptions: this.availableOptions,
                        },
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
