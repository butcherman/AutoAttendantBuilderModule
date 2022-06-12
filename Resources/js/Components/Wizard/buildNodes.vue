<template>
    <div>
        <h1 class="text-center text-dark">Almost Done!</h1>
        <p class="text-center">
            Please wait while I go through this information and build your Auto Attendant Tree.
        </p>
        <div class="text-center">
            <atom-loader></atom-loader>
        </div>
    </div>
</template>

<script>
    import { NewNode } from '../../Modules/defaultData';

    export default {
        props: {
            activeStep: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                nodeId: 100,        //  TODO - fix this to be proper
            }
        },
        created() {
            //
        },
        mounted() {
            let flowNodes = [];
            for(let step of this.activeStep.data)
            {
                if(step.node)
                {
                    step.node.valid = true;
                    flowNodes.push(step.node);

                    if(step.node.parentId >= 0)
                    {
                        let parentNode = flowNodes.find(node => node.id === step.node.parentId);
                        parentNode.hasChildren = true;
                    }
                }
                else if(step.component === 'dial-options-wizard')
                {
                    let dialOptions = step.data.steps.options;

                    for(let option of dialOptions)
                    {
                        let newOptionNode = new NewNode(step.data.parentId, 'dial-option', option);

                        newOptionNode.data.availableOptions = [0,1,2,3,4,5,6,7,8,9,11];
                        newOptionNode.data.num = newOptionNode.data.optNum;
                        newOptionNode.valid = true;
                        newOptionNode.id = this.nodeId++;

                        console.log(newOptionNode);

                        flowNodes.push(newOptionNode);

                        //  Build the sub node
                        let defaultData = {};
                        let componentType = null;

                        switch(option.whatHappens)
                        {
                            case 'Hang Up':
                            case 'Repeat':
                            case 'Staff Directory':
                                componentType = 'textBlock';
                                defaultData.text = option.whatHappens;
                                break;
                            case 'Ring Phone(s)':
                            case 'Take Message':
                                componentType = 'gotoPhones';
                                defaultData.headerText = option.whatHappens;
                                defaultData.extList = option.targetExtension;
                                break;
                            case 'Play Greeting':
                                componentType = 'greeting';
                                defaultData = {
                                    headerText      : 'Sub Greeting',
                                    greeting        : '',
                                    availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                                }
                        }

                        let newDialNode = new NewNode(newOptionNode.id, componentType, defaultData);
                        newDialNode.id = this.nodeId++;
                        newDialNode.valid = true;

                        flowNodes.push(newDialNode);
                    }
                }


            }

            console.log(flowNodes);

            this.$inertia.post(route('AutoAttendantBuilderModule.store'), flowNodes);

        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            //
        },
    }
</script>
