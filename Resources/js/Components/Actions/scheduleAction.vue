<template>
    <div class="text-center">
        <b-button
            variant="info"
            pill
            v-b-modal.form-modal
        >
            Modify Schedule
        </b-button>
        <b-button
            variant="danger"
            pill
            @click="verifyDelete"
        >
            Delete Schedule
        </b-button>
        <b-modal
            id="form-modal"
            ref="form-modal"
            title="Schedule"
            hide-footer
        >
            <schedule-form
                :headerText="node.data.headerText"
                :schedule="node.data.schedule"
                @save="saveData"
            />
        </b-modal>
    </div>
</template>

<script>
    import { mapStores }           from 'pinia';
    import { useFlowStore }        from '../../Stores/flowStore';
    import { DefaultGreetingData } from '../../Modules/defaultData';
    import scheduleForm            from '../Forms/scheduleForm.vue';

    export default {
        components: { scheduleForm },
        props: {
            node: {
                type: Object,
                required: true,
            }
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
                this.node.data.headerText = data.headerText;
                this.node.data.schedule   = data.schedule;
                this.node.valid           = true;

                this.$refs['form-modal'].hide();
                this.buildGreetings();
            },
            buildGreetings()
            {
                let greetArr = ['On Hours Greeting', 'Off Hours Greeting'];
                for(let greet of greetArr)
                {
                    let defaultData = new DefaultGreetingData;
                    defaultData.headerText = greet;

                    this.flowStore.buildNode(this.node.id, 'greeting', defaultData);
                }
            },
            verifyDelete()
            {
                this.$emit('delete_me');
            }
        },
    }
</script>
