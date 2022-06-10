<template>
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <ValidationObserver v-slot="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(save)" novalidate>
                    <b-form-group v-for="(opt, index) in form.options" :key="index">
                        <b-form-group class="border border-dark p-4">
                            <div class="row justify-content-center">
                                <div class="col-6">
                                    <dropdown-input
                                        v-if="opt.optNum !== 11"
                                        v-model="opt.optNum"
                                        rules="required"
                                        name="dialOption"
                                        :label="opt.verbage"
                                        :options="dropDownList"
                                    ></dropdown-input>
                                    <div v-else>Time Out:</div>
                                </div>
                                <div class="col-6">
                                    <dropdown-input
                                        v-model="opt.whatHappens"
                                        rules="required"
                                        name="whatHappens"
                                        label="What Happens"
                                        :options="whatHappensOptions"
                                    ></dropdown-input>
                                    <Transition name="slide-fade">
                                        <div v-if="opt.whatHappens === 'Take Message' || opt.whatHappens === 'Ring Phone(s)'">
                                            <h5 class="text-center text-dark">For The Following Extensions</h5>
                                            <div v-for="ext in opt.targetExtension" :key="ext" class="text-center">
                                                {{ext}}
                                                <i class="fas fa-minus-circle text-danger pointer" title="Remove Extension" v-b-tooltip.hover @click="remExt(ext, opt.targetExtension)"></i>
                                            </div>
                                            <div class="text-center">
                                                Add Extension
                                                <input type="text" class="w-75" v-model="addingExt" />
                                                <b-button pill size="sm" variant="info" @click="addExt(opt.targetExtension)"><i class="fas fa-plus"></i></b-button>
                                            </div>
                                        </div>
                                    </Transition>
                                </div>
                            </div>
                        </b-form-group>
                    </b-form-group>
                    <div class="text-center">
                        <b-button pill variant="info" @click="addOption">Add Option</b-button>
                    </div>
                    <div class="text-center mt-3">
                        <b-button pill variant="success" type="submit">{{saveText}}</b-button>
                        <b-button pill variant="danger" @click="reset" v-if="!hideReset">Reset</b-button>
                    </div>
                </b-form>
            </ValidationObserver>
        </div>
    </div>
</template>

<script>
    import { whatHappensDropdown } from '../../Modules/greetingMethods';

    export default {
        props: {
            dialOptions: {
                type: Array,
                required: true,
            },
            saveText: {
                type: String,
                required: false,
                default: 'Save',
            },
            hideReset: {
                type: Boolean,
                required: false,
                default: false,
            },
            showBack: {
                type: Boolean,
                required: false,
                default: true,
            }
        },
        data() {
            return {
                form: {
                    options: [...this.dialOptions],
                },
                addingExt: null,
                dropDownList: [0,1,2,3,4,5,6,7,8,9],
                whatHappensOptions: whatHappensDropdown,
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
            save()
            {
                this.$emit('save', this.form);
            },
            reset()
            {
                console.log('reset');
            },
            addOption()
            {
                this.form.options.push({
                    optNum: null,
                    verbage: 'Press',
                    targetExtension: [],
                });
            },
            addExt(extArr)
            {
                extArr.push(this.addingExt);
                this.addingExt =null;
            },
            remExt(ext, extArr)
            {
                extArr.splice(extArr.indexOf(ext), 1);
            }
        },
    }
</script>

<style>
    .slide-fade-enter-active {
        transition: all 0.3s ease-out;
    }

    .slide-fade-leave-active {
        transition: all 0.8s cubic-bezier(1, 0.5, 0.8, 1);
    }

    .slide-fade-enter-from,
    .slide-fade-leave-to {
        transform: translateX(20px);
        opacity: 0;
    }
</style>
