<template>
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <ValidationObserver v-slot="{handleSubmit}">
                <b-form @submit.prevent="handleSubmit(save)" novalidate>
                    <b-form-group v-for="(opt, index) in form.options" :key="index">
                        <b-form-group class="border border-dark p-4">
                            <div class="row justify-content-center">
                                <div class="col-4 d-flex align-items-center">
                                    <dropdown-input
                                        v-if="opt.optNum !== 11"
                                        :value="opt.optNum"
                                        name="dialOption"
                                        class="w-100"
                                        :rules="`required|unique-one-key:${form}`"
                                        :label="opt.verbage"
                                        :options="dropDownList"
                                        @change="updateUsedOptions(opt, $event)"
                                    ></dropdown-input>
                                    <div v-else>
                                       Time Out:
                                    </div>
                                </div>
                                <div class="col-6 d-flex align-items-center">
                                    <dropdown-input
                                        v-model="opt.whatHappens"
                                        rules="required"
                                        name="whatHappens"
                                        label="What Happens"
                                        :options="whatHappensOptions"
                                    ></dropdown-input>
                                </div>
                            </div>
                            <Transition name="slide-fade">
                                <div v-if="opt.whatHappens === 'Take Message' || opt.whatHappens === 'Ring Phone(s)'">
                                    <h5 class="text-center text-dark">For The Following Extensions</h5>
                                    <div v-for="ext in opt.targetExtension" :key="ext" class="text-center">
                                        {{ext}}
                                        <i class="fas fa-minus-circle text-danger pointer" title="Remove Extension" v-b-tooltip.hover @click="remExt(ext, opt.targetExtension)"></i>
                                    </div>
                                    <div class="text-center">
                                        Add Extension <i class="far fa-question-circle pointer" title="Help" v-b-tooltip.hover v-b-modal.help-modal></i>
                                        <input type="text" class="w-75" v-model="addingExt" @keydown.enter.prevent="addExt(opt.targetExtension)" />
                                        <b-button pill size="sm" variant="info" @click="addExt(opt.targetExtension)"><i class="fas fa-plus"></i></b-button>
                                    </div>
                                </div>
                            </Transition>
                            <div class="text-center" v-if="opt.optNum !== 11">
                                <i class="far fa-trash-alt text-danger pointer" title="Remove Option" v-b-tooltip.hover @click="remOption(opt)"></i>
                            </div>
                        </b-form-group>
                    </b-form-group>
                    <b-modal id="help-modal" title="Help" ok-only>
                        <p>Enter an extension number and press the <i class="fas fa-plus text-info"></i> button</p>
                        <p>Repeat this for each extension that should be included in this list</p>
                    </b-modal>
                    <div class="text-right">
                        <b-button pill variant="info" @click="addOption"><i class="fas fa-plus d-none d-sm-inline"></i> Add Option</b-button>
                    </div>
                    <div class="text-center mt-3">
                        <b-button class="w-25" variant="success" type="submit">{{saveText}}</b-button>
                        <b-button class="w-25" variant="danger" type="reset" @click="reset" v-if="!hideReset">Reset</b-button>
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
                    options    : [],
                    usedOptions: [],
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
            this.reset();
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
                this.form.usedOptions = [];
                this.form.options     = [];

                this.dialOptions.forEach(opt => {
                    this.form.options.push(structuredClone(opt));
                    this.form.usedOptions.push(opt.optNum);
                })
            },
            addOption()
            {
                this.form.options.push({
                    optNum         : null,
                    verbage        : 'Press',
                    targetExtension: [],
                });
            },
            remOption(opt)
            {
                console.log(opt);

                this.form.options.splice(this.form.options.indexOf(opt), 1);
            },
            addExt(extArr)
            {
                extArr.push(this.addingExt);
                this.addingExt =null;
            },
            remExt(ext, extArr)
            {
                extArr.splice(extArr.indexOf(ext), 1);
            },
            updateUsedOptions(item, newValue)
            {
                //  TODO - Validate one key options so that they can only be used once
                if(item.optNum !== null)
                {
                    this.form.usedOptions.splice(this.form.usedOptions.indexOf(item.optNum), 1, newValue);
                }
                else
                {
                    this.form.usedOptions.push(newValue);
                }
            }
        },
    }
</script>
