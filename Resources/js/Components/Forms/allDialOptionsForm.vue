<template>
    <div class="row justify-content-center mb-4">
        <div class="col-md-8">
            <ValidationObserver v-slot="{handleSubmit}">
                <b-form
                    novalidate
                    @submit.prevent="handleSubmit(save)"
                    @reset.prevent="reset"
                >
                    <b-form-group
                        v-for="(opt, index) in form.options"
                        :key="index"
                    >
                        <b-form-group class="border border-dark p-4">
                            <div class="row justify-content-center">
                                <div class="col-4 d-flex align-items-center">
                                    <dropdown-input
                                        v-if="opt.optNum !== 11"
                                        name="dialOption"
                                        class="w-100"
                                        v-model="opt.optNum"
                                        :rules="`required|unique-one-key:${form.usedOptions}`"
                                        :label="opt.verbage"
                                        :options="dropDownList"
                                        @change="updateUsedOptions(opt, $event)"
                                    />
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
                                    />
                                </div>
                            </div>
                            <Transition name="slide-fade">
                                <div
                                    v-if="opt.whatHappens === 'Take Message'
                                        || opt.whatHappens === 'Ring Phone(s)'"
                                >
                                    <h5 class="text-center">
                                        For The Following Extensions
                                    </h5>
                                    <div
                                        v-for="ext in opt.targetExtension"
                                        :key="ext"
                                        class="text-center"
                                    >
                                        {{ext}}
                                        <i
                                            class="fas fa-minus-circle text-danger pointer"
                                            title="Remove Extension"
                                            v-b-tooltip.hover
                                            @click="remExt(ext, opt.targetExtension)"
                                        />
                                    </div>
                                    <div class="text-center">
                                        Add Extension
                                        <i
                                            class="far fa-question-circle pointer"
                                            title="Help"
                                            v-b-tooltip.hover
                                            v-b-modal.help-modal
                                        />
                                        <input
                                            type="text"
                                            class="w-75"
                                            v-model="opt.addingExt"
                                            @keydown.enter.prevent="addExt(opt.targetExtension, opt.addingExt)"
                                        />
                                        <b-button
                                            pill
                                            size="sm"
                                            variant="info"
                                            @click="addExt(opt.targetExtension, opt.addingExt)"
                                        >
                                            <i class="fas fa-plus" />
                                        </b-button>
                                    </div>
                                </div>
                            </Transition>
                            <div class="text-center" v-if="opt.optNum !== 11">
                                <i
                                    class="far fa-trash-alt text-danger pointer"
                                    title="Remove Option"
                                    v-b-tooltip.hover
                                    @click="remOption(opt)"
                                />
                            </div>
                        </b-form-group>
                    </b-form-group>
                    <b-modal id="help-modal" title="Help" ok-only>
                        <p>
                            Enter an extension number and press the
                            <i class="fas fa-plus text-info" /> button
                        </p>
                        <p>
                            Repeat this for each extension that should be
                            included in this list
                        </p>
                    </b-modal>
                    <div class="text-right">
                        <b-button
                            v-if="canAddOption"
                            pill
                            variant="info"
                            @click="addOption"
                        >
                            <i class="fas fa-plus d-none d-sm-inline" />
                            Add Option
                        </b-button>
                    </div>
                    <div class="text-center mt-3">
                        <b-button class="w-25" variant="success" type="submit">
                            {{saveText}}
                        </b-button>
                        <b-button class="w-25" variant="danger" type="reset">
                            Reset
                        </b-button>
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
                type    : Array,
                required: true,
            },
            saveText: {
                type   : String,
                default: 'Save',
            },
            showBack: {
                type   : Boolean,
                default: true,
            }
        },
        data() {
            return {
                form: {
                    options    : [],
                    usedOptions: [],
                },
                addingExt         : null,
                dropDownList      : [0,1,2,3,4,5,6,7,8,9],
                whatHappensOptions: whatHappensDropdown,
            }
        },
        mounted() {
            this.reset();
        },
        computed: {
            canAddOption()
            {
                return this.form.options.length < 11;
            },
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
                });
            },
            addOption()
            {
                if(this.canAddOption)
                {
                    let newOption = {
                        optNum         : null,
                        verbage        : 'Press',
                        targetExtension: [],
                    }

                    this.form.options.push(structuredClone(newOption));
                }
            },
            remOption(opt)
            {
                this.form.options.splice(this.form.options.indexOf(opt), 1);
            },
            addExt(extArr, extToAdd)
            {
                extArr.push(extToAdd);
            },
            remExt(ext, extArr)
            {
                extArr.splice(extArr.indexOf(ext), 1);
            },
            updateUsedOptions(item, newValue)
            {
                if(item.optNum !== null)
                {
                    this.form.usedOptions.splice(this.form.usedOptions.indexOf(item.optNum), 1);
                }

                this.form.usedOptions.push(newValue);
            }
        },
    }
</script>
