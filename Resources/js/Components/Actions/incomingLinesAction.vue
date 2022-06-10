<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Line Data</b-button>
        <b-button v-if="node.valid && !node.hasChildren" pill variant="info" @click="giveBirth('greeting')">Add Greeting</b-button>
        <b-button v-if="node.valid && !node.hasChildren" pill variant="info" @click="giveBirth('schedule')">Add Schedule</b-button>
        <b-modal ref="form-modal" id="form-modal" title="Incoming Lines" hide-footer>
            <incoming-lines-form :lineList="[...node.data.lineList]" @save="saveData"></incoming-lines-form>
        </b-modal>
    </div>
</template>

<script>
import incomingLinesForm from '../Forms/incomingLinesForm.vue';
    export default {
        components: { incomingLinesForm },
        props: {
            node: {
                type: Object,
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
        methods: {
            saveData(data)
            {
                this.node.data.lineList = data.lineList;
                this.node.valid = true;
                this.$refs['form-modal'].hide();
            },
            giveBirth(toWhat)
            {
                let defaultData;

                if(toWhat === 'greeting')
                {
                    defaultData = {
                        headerText      : '24/7 Greeting',
                        greeting        : '',
                        availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                    }
                }
                else if(toWhat === 'schedule')
                {
                    defaultData = {
                        headerText: 'Business Hours',
                        schedule  : [
                            {
                                start_time: '08:00',
                                stop_time : '17:00',
                                days      : ['mon', 'tue', 'wed', 'thu', 'fri'],
                            }
                        ]
                    }
                }

                this.$emit('giveBirth', {
                    component: toWhat,
                    data     : defaultData,
                });
            }
        },
    }
</script>
