<template>
    <div>
        <ValidationObserver v-slot="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(save)" novalidate>
                <text-input v-model="form.title" rules="required" label="Schedule Name" name="title"></text-input>
                <fieldset>
                    <label>Schedule Details</label>
                    <div class="row my-4 border-top" v-for="(sch, key) in form.schedule" :key="key">
                        <div class="col-md-6">
                            <b-form-group label="Start Time:" label-for="start_time">
                                <b-form-timepicker v-model="sch.start_time" locale="en" name="start_time"></b-form-timepicker>
                            </b-form-group>
                        </div>
                        <div class="col-md-6">
                            <b-form-group label="Stop Time:" label-for="stop_time">
                                <b-form-timepicker v-model="sch.stop_time" locale="en" name="stop_time"></b-form-timepicker>
                            </b-form-group>
                        </div>
                        <div class="col">
                            <b-form-checkbox-group
                                v-model="sch.days"
                                :options="days"
                                name="days"
                            ></b-form-checkbox-group>
                        </div>
                    </div>
                    <div class="clearfix">
                        <b-button size="sm" pill class="float-right" variant="info" @click="form.schedule.push(blankEntry)"><i class="fas fa-plus d-none d-sm-inline" aria-hidden="true"></i> Add</b-button>
                    </div>
                </fieldset>
                <div class="text-center">
                    <b-button pill variant="success" type="submit">Save</b-button>
                    <b-button pill variant="danger" @click="reset">Reset</b-button>
                </div>
            </b-form>
        </ValidationObserver>
    </div>
</template>

<script>
    export default {
        props: {
            nodeId: {
                type: Number,
                required: true,
            },
            schedule: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                submitted: false,
                days: [
                    {
                        text: 'Sun',
                        value: 'sun',
                    },
                    {
                        text: 'Mon',
                        value: 'mon',
                    },
                    {
                        text: 'Tue',
                        value: 'tue',
                    },
                    {
                        text: 'Wed',
                        value: 'wed',
                    },
                    {
                        text: 'Thu',
                        value: 'thu',
                    },
                    {
                        text: 'Fri',
                        value: 'fri',
                    },
                    {
                        text: 'Sat',
                        value: 'sat',
                    },
                ],
                blankEntry: {
                    start_time: null,
                    stop_time: null,
                    days: [],
                },
                form: {
                    title: this.schedule.title,
                    schedule: this.schedule.schedule,
                }
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
            //
            save()
            {
                console.log('save');
                var saveData = {
                    nodeId: this.nodeId,
                    schedule: this.form,
                }
                this.$emit('save', {nodeId: this.nodeId, data: saveData});
            },
            reset()
            {
                this.form = {
                    title: 'Business Hours',
                    schedule: [
                        {
                            start_time: '08:00',
                            stop_time: '17:00',
                            days: ['mon', 'tue', 'wed', 'thu', 'fri'],
                        }
                    ]
                }
            }
        },
    }
</script>
