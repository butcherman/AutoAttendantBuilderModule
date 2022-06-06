<template>
    <div class="row justify-content-center mb-4">
        <div class="col-md-6">
            <ValidationObserver v-slot="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(save)" novalidate>
                    <b-form-group v-for="(opt, index) in form.options" :key="index">
                        <b-form-group class="border border-dark p-4">
                            <dropdown-input
                                v-if="opt.optNum !== 11"
                                v-model="opt.optNum"
                                rules="required"
                                name="dialOption"
                                :label="opt.verbage"
                                :options="dropDownList"
                            ></dropdown-input>
                            <div v-else>Time Out:</div>
                            <dropdown-input
                                v-model="opt.whatHappens"
                                rules="required"
                                name="whatHappens"
                                label="What Happens"
                                :options="whatHappensOptions"
                            ></dropdown-input>
                            <Transition>
                                <div v-if="opt.whatHappens === 'Take Message' || opt.whatHappens === 'Ring Phone(s)'">
                                    <h5 class="text-center text-dark">For The Following Extensions</h5>
                                    <div v-for="(ext, index) in opt.targetExtension" :key="index" class="text-center">
                                        {{ext}}
                                        <i class="fas fa-minus-circle text-danger pointer" title="Remove Extension" v-b-tooltip.hover @click="remExt"></i>
                                    </div>
                                    <div class="text-center">
                                        Add Extension
                                        <input type="text" v-model="addingExt" />
                                        <b-button pill size="sm" variant="info" @click="addExt(opt)"><i class="fas fa-plus"></i></b-button>
                                    </div>
                                </div>
                            </Transition>
                        </b-form-group>
                    </b-form-group>

                    <div class="text-center mt-3">
                        <b-button pill variant="success" type="submit">Next</b-button>
                        <b-button pill variant="danger" @click="reset">Reset</b-button>
                    </div>
                </b-form>
            </ValidationObserver>

        </div>
    </div>
</template>

<script>
    export default {
        props: {
            dialOptions: {
                type: Array,
                required: true,
            }
        },
        data() {
            return {
                verbage: 'Press',
                form: {
                    options: [],
                },
                addingExt: null,
                dropDownList: [0,1,2,3,4,5,6,7,8,9],
                whatHappensOptions: [
                    '',
                    'Play Greeting',
                    'Take Message',
                    'Ring Phone(s)',
                    'Staff Directory',
                    'Repeat',
                    'Hang Up',
                ],
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
            dialOptions()
            {
                this.dialOptions.forEach(opt => {
                    opt.whatHappens = '';
                    opt.targetExtension = [];
                    this.form.options.push(opt)
                });
            }
        },
        methods: {
            save()
            {
                console.log(this.form.options);
                console.log('save');
            },
            reset()
            {
                console.log('reset');
                alert('reset');
            },
            addExt(opt)
            {
                opt.targetExtension.push(this.addingExt);
                this.addingExt = null;
            },
            remExt(opt)
            {
                console.log(opt);
                alert('TODO - FIX ME');
            }
        },
    }
</script>
