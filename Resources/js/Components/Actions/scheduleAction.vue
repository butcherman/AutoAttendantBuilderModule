<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Schedule</b-button>
        <b-modal ref="form-modal" id="form-modal" title="Schedule" hide-footer>
            <schedule-form :headerText="node.data.headerText" :schedule="formSchedule" @save="saveData"></schedule-form>
        </b-modal>
    </div>
</template>

<script>
    import scheduleForm from '../Forms/scheduleForm.vue';

    export default {
        components: { scheduleForm },
        props: {
            node: {
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
            //  If this data is not yet valid, open the form to edit
            if(!this.node.valid)
            {
                this.$refs['form-modal'].show();
            }
        },
        computed: {
            formSchedule()
            {
                let newSch = [];
                this.node.data.schedule.forEach(elem => {
                    let newObj = {
                        start_time: elem.start_time,
                        stop_time: elem.stop_time,
                        days: [...elem.days],
                    };

                    newSch.push(newObj);
                });

                return newSch;
            }
        },
        watch: {
            //
        },
        methods: {
            saveData(data)
            {
                this.node.valid           = true;
                this.node.data.headerText = data.headerText;
                this.node.data.schedule   = data.schedule;

                this.$refs['form-modal'].hide();

                this.buildGreetings();
            },
            buildGreetings()
            {
                let onHoursData = {
                    headerText: 'On Hours Greeting',
                    greeting: '',
                    availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                }

                let offHoursData = {
                    headerText: 'Off Hours Greeting',
                    greeting: '',
                    availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                }

                this.$emit('giveBirth', {
                    component: 'greeting',
                    data     : onHoursData,
                });
                this.$emit('giveBirth', {
                    component: 'greeting',
                    data     : offHoursData,
                });

            }
        },
    }
</script>
