<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Line Data</b-button>
        <b-button v-if="valid && !hasChildren" pill variant="info" @click="giveBirth('greeting')">Add Greeting</b-button>
        <b-button v-if="valid && !hasChildren" pill variant="info" @click="giveBirth('schedule')">Add Schedule</b-button>
        <b-modal ref="form-modal" id="form-modal" title="Incoming Lines" hide-footer>
            <incoming-line-form :lineList="lineList" @save="saveData"></incoming-line-form>
        </b-modal>
    </div>
</template>

<script>
    import incomingLineForm from '../Forms/incomingLineForm.vue';

    export default {
        components: { incomingLineForm },
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
            lineList: {
                type: Array,
                required: true,
            },
        },
        mounted() {
            if(!this.valid)
            {
                this.$refs['form-modal'].show();
            }
        },
        methods: {
            saveData(data)
            {
                this.$emit('saveData', {
                    nodeId     : this.nodeId,
                    valid      : true,
                    hasChildren: this.hasChildren,
                    headerText : 'Incoming Lines',
                    lineList   : data.lineList,
                });
                this.$refs['form-modal'].hide();
            },
            giveBirth(type)
            {
                let defaultData;

                if(type === 'greeting')
                {
                    defaultData = {
                        greetingTitle   : '24/7 Greeting',
                        greeting        : '',
                        availableOptions: [0,1,2,3,4,5,6,7,8,9],
                    }
                }
                else if(type === 'schedule')
                {
                    defaultData = {
                        title: 'Business Hours',
                        schedule: [
                            {
                                start_time: '08:00',
                                stop_time : '17:00',
                                days      : ['mon', 'tue', 'wed', 'thu', 'fri'],
                            }
                        ]
                    }
                }

                this.$emit('giveBirth', {
                    type: type,
                    data: defaultData,
                });
            }
        },
    }
</script>
