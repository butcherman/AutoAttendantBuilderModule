<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <p>
                    Now that we know what the greeting should say, we need to determine what happens when
                    callers press the buttons they are told to press.  For each option below, define what
                    should happen to the call when that option is pressed.
                </p>
                <p>
                    The Time Out option is for when the caller does not press anything, but instead just stays
                    on the line. We need to know what to do with the call in this instance as well.
                </p>
                <p>
                    We have included the options that were in your script, but if you would like to add additional
                    option, use the Add button to assign them.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <all-dial-options-form
                    :dialOptions="dialOptions"
                    saveText="Next"
                    hideReset
                    showBack
                    @save="save"
                ></all-dial-options-form>
            </div>
        </div>
    </div>
</template>

<script>
    import allDialOptionsForm from '../Forms/allDialOptionsForm.vue';
    import { findDialOptions } from '../../Modules/greetingMethods';
import { DefaultGreetingData, NewNode } from '../../Modules/defaultData';

    export default {
        components: { allDialOptionsForm },
        props: {
            activeStep: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                dialOptions: findDialOptions(this.activeStep.data.greeting),
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
            save(data)
            {
                this.activeStep.data.steps = data;
                let hasGreeting = [];

                for(let d of data.options)
                {
                    if(d.whatHappens === 'Play Greeting')
                    {
                        hasGreeting.push(d);
                    }
                }

                if(hasGreeting.length)
                {
                    let nextStep = [];

                    for(let g of hasGreeting)
                    {

                        let defaultData = new DefaultGreetingData;

                        if(g.optNum === 11)
                        {
                            defaultData.headerText = 'Time Out Greeting';
                        }
                        else
                        {
                            defaultData.headerText = 'Option '+g.optNum+' Greeting';
                        }

                        nextStep.push({
                            component: 'greeting-wizard',
                            node: new NewNode(this.activeStep.data.parentId, 'greeting', defaultData),
                        });
                    }

                    this.$emit('nextStep', nextStep);
                }
                else
                {
                    this.$emit('endOfLine');
                }
            }
        },
    }
</script>
