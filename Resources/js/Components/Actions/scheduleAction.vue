<template>
    <div class="text-center">
        <b-button pill variant="info" v-b-modal.form-modal>Modify Schedule</b-button>
        <b-modal ref="form-modal" id="form-modal" title="Schedule" hide-footer>
            <schedule-form :title="title" :schedule="schedule" @save="saveData"></schedule-form>
        </b-modal>
    </div>
</template>

<script>
    export default {
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
            title: {
                type: String,
                required: true,
            },
            schedule: {
                type: Array,
                required: true,
            }
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
                console.log(data);

                this.$emit('saveData', {
                    nodeId     : this.nodeId,
                    valid      : true,
                    hasChildren: this.hasChildren,
                    title      : data.title,
                    schedule   : data.schedule,
                });
                this.$refs['form-modal'].hide();
                this.buildGreetings();
            },
            /**
             * Build the on hours and off hours greetings
             */
            buildGreetings()
            {
                let onHoursData = {
                    greetingTitle   : 'On Hours Greeting',
                    greeting        : '',
                    availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                }

                let offHoursData = {
                    greetingTitle   : 'Off Hours Greeting',
                    greeting        : '',
                    availableOptions: [0,1,2,3,4,5,6,7,8,9,11],
                }

                this.giveBirth(onHoursData);
                this.giveBirth(offHoursData);
            },
            giveBirth(data)
            {
                this.$emit('giveBirth', {
                    type: 'greeting',
                    data: data,
                });
            }
        },
    }
</script>
