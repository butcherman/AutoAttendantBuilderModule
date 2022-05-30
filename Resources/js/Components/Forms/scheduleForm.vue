<template>
    <div>
        <h4 class="text-center text-dark">
            Schedules
            <i class="far fa-question-circle pointer" title="Help" v-b-tooltip.hover v-b-modal.help-modal></i>
        </h4>
        <b-modal id="help-modal" title="Help" ok-only>
            <p>
                If you wish to play separate greetings for when you are open vs. when you are closed, please fill
                out the schedule information below
            </p>
            <p>
                Any time frame referenced below will be conisdered "On Hours" or Open Hours.  All other times not
                referenced will be considered "Off Hours" or Closed Hours
            </p>
        </b-modal>
        <ValidationObserver v-slot="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(save)" novalidate>
                <text-input v-model="form.title" rules="required" label="Schedule Name" name="title"></text-input>
                <fieldset>
                    <label>Schedule Details</label>
                    <div class="row my-4 border-top" v-for="(sch, key) in form.schedule" :key="key">
                        <div class="col-md-6">
                            <ValidationProvider v-slot="v" :rules="key == 0 ? 'required' : null" name="start_time">
                                <b-form-group label="Start Time:" label-for="start_time">
                                    <b-form-timepicker v-model="sch.start_time" locale="en"></b-form-timepicker>
                                    <b-form-invalid-feedback :state="false">{{v.errors[0]}}</b-form-invalid-feedback>
                                </b-form-group>
                            </ValidationProvider>
                        </div>
                        <div class="col-md-6">
                            <ValidationProvider v-slot="v" rules="after-start:@start_time" name="stop_time">
                                <b-form-group label="Stop Time:" label-for="stop_time">
                                    <b-form-timepicker v-model="sch.stop_time" locale="en"></b-form-timepicker>
                                    <b-form-invalid-feedback :state="false">{{v.errors[0]}}</b-form-invalid-feedback>
                                </b-form-group>
                            </ValidationProvider>
                        </div>
                        <div class="col">
                            <ValidationProvider v-slot="v" :rules="key == 0 ? 'required' : null">
                                <b-form-checkbox-group
                                    v-model="sch.days"
                                    :options="days"
                                    name="days"
                                ></b-form-checkbox-group>
                                <b-form-invalid-feedback :state="false">{{v.errors[0]}}</b-form-invalid-feedback>
                            </ValidationProvider>
                        </div>
                    </div>
                    <div class="clearfix">
                        <b-button size="sm" pill class="float-right" variant="info" @click="addRow"><i class="fas fa-plus d-none d-sm-inline" aria-hidden="true"></i> Add</b-button>
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
    require('../../validateRules');
    export default {
        props: {
            title: {
                type: String,
                required: true,
            },
            schedule: {
                type: Array,
                required: true,
            }
        },
        data() {
            return {
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
                form: {
                    title   : null,
                    schedule: [],
                }
            }
        },
        mounted() {
            this.reset();
        },
        methods: {
            addRow()
            {
                this.form.schedule.push({
                    start_time: null,
                    stop_time : null,
                    days      : [],
                });
            },
            save()
            {
                //  Break the reactive state that causes updates to push back into props
                var newSchedule = {
                    title   : this.form.title,
                    schedule: this.form.schedule,
                };

                this.$emit('save', newSchedule);
            },
            reset()
            {
                this.form.title = this.title;
                this.form.schedule = [];

                this.schedule.forEach(sch => {
                    this.form.schedule.push(sch);
                })
            },
        },
    }
</script>
