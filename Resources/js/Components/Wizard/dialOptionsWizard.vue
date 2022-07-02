<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <h3>One Key Options</h3>
                <p>
                    Now that we know what the greeting should say, we need to
                    determine what happens when callers press the buttons they
                    are told to press.  For each option below, define what should
                    happen to the call when that option is pressed.
                </p>
                <p>
                    The Time Out option is for when the caller does not press
                    anything, but instead just stays on the line. We need to
                    know what to do with the call in this instance as well.
                </p>
                <p>
                    We have included the options that were found in your script,
                    but if you would like to add additional option, use the Add
                    button to assign them.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <all-dial-options-form
                    :dialOptions="dialOptions"
                    saveText="Next"
                    @save="save"
                />
            </div>
        </div>
    </div>
</template>

<script>
    import allDialOptionsForm      from '../Forms/allDialOptionsForm.vue';
    import { findDialOptions }     from '../../Modules/greetingMethods';
    import { DefaultGreetingData } from '../../Modules/defaultData';
    import { useFlowStore }  from '../../Stores/flowStore';
    import { mapStores }     from 'pinia';

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
        computed: {
            ...mapStores(useFlowStore),
        },
        methods: {
            save(data)
            {
                this.activeStep.data = data;

                let nextStep = [];
                let componentType;
                let defaultData;

                data.options.forEach(option => {
                    switch(option.whatHappens)
                    {
                        case 'Hang Up':
                        case 'Repeat':
                        case 'Staff Directory':
                            componentType = 'textBlock';
                            defaultData   = { text: option.whatHappens };
                            break;
                        case 'Ring Phone(s)':
                        case 'Take Message':
                            componentType = 'gotoPhones';
                            defaultData   = {
                                headerText: option.whatHappens,
                                extList   : option.targetExtension,
                            }
                            break;
                        case 'Play Greeting':
                            componentType          = 'greeting';
                            defaultData            = new DefaultGreetingData;
                            defaultData.headerText = 'Sub Menu';
                    }

                    let nodeData = {
                        num: option.optNum,
                        headerText: `${option.verbage} ${option.optNum !== 11 ? option.optNum : ''}`,
                    }
                    let newNode = this.flowStore.buildNode(this.activeStep.parentId, 'dialOption', nodeData);

                    if(option.whatHappens === 'Play Greeting')
                    {
                        defaultData = new DefaultGreetingData;
                        defaultData.headerText = `${option.verbage} ${option.optNum !== 11 ? option.optNum : ''} Sub Menu`;
                        nextStep.push({
                            component: 'greeting-wizard',
                            data     : defaultData,
                            parentId : newNode.id,
                        });
                    }
                    else
                    {
                        this.flowStore.buildNode(newNode.id, componentType, defaultData);
                    }
                });

                this.activeStep.nextStep = nextStep;
                this.$emit('nextStep');
            },
        },
    }
</script>
