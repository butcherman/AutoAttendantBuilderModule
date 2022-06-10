<template>
    <div>
        <h1 class="text-center text-dark">All Done</h1>
        <p class="text-center">
            Please wait while I go through this information and build your Auto Attendant Tree.
        </p>
        <div class="text-center">
            <atom-loader></atom-loader>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            activeStep: {
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
            //
            console.log(this.activeStep);

            let flowNodes = [];
            for(let step of this.activeStep.data)
            {
                console.log(step);

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


            }

            console.log(flowNodes);

            //  TODO - build one key option nodes
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
