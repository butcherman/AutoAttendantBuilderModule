<template>
    <div class="text-center">
        <b-button
            variant="info"
            pill
            v-b-modal.form-modal
        >
            Modify Line Data
        </b-button>
        <b-button
            v-if="node.valid && !node.hasChildren"
            variant="info"
            pill
            @click="buildNext('greeting')"
        >
            Add Greeting
        </b-button>
        <b-button
            v-if="node.valid && !node.hasChildren"
            variant="info"
            pill
            @click="buildNext('schedule')"
        >
            Add Schedule
        </b-button>
        <b-modal
            id="form-modal"
            ref="form-modal"
            title="Incoming Lines"
            hide-footer
        >
            <incoming-lines-form
                :lineList="node.data.lineList"
                @save="saveData"
            />
        </b-modal>
    </div>
</template>

<script>
    import { DefaultGreetingData, DefaultScheduleData } from '../../Modules/defaultData';
    import incomingLinesForm from '../Forms/incomingLinesForm.vue';
    import { useFlowStore }  from '../../Stores/flowStore';
    import { mapStores }     from 'pinia';

    export default {
        components: { incomingLinesForm },
        props: {
            node: {
                type    : Object,
                required: true,
            },
        },
        mounted() {
            //  If this data is not yet valid, open the form to edit
            if(!this.node.valid)
            {
                this.$refs['form-modal'].show();
            }
        },
        computed: {
            ...mapStores(useFlowStore),
        },
        methods: {
            saveData(data)
            {
                this.node.data.headerText = 'Incoming Phone Numbers';
                this.node.data.lineList   = data.lineList;
                this.node.valid           = true;
                this.$refs['form-modal'].hide();
            },
            buildNext(type)
            {
                let defaultData;
                switch(type)
                {
                    case 'greeting':
                        defaultData = new DefaultGreetingData;
                        break;
                    case 'schedule':
                        defaultData = new DefaultScheduleData;
                        break;
                }

                this.flowStore.buildNode(this.node.id, type, defaultData);
            }
        },
    }
</script>
