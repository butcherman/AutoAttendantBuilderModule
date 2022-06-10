<template>
    <div>
        <h4 class="text-center text-dark">
            What Happens On This Option
            <i class="far fa-question-circle pointer" title="Help" v-b-tooltip.hover v-b-modal.help-modal></i>
        </h4>
        <b-modal id="help-modal" title="Help" ok-only>
            <p>Each one key option must have some type of destination.</p>
            <p>Use this form to tell us what that destination is.</p>
        </b-modal>
        <ValidationObserver v-slot="{handleSubmit}">
            <b-form @submit.prevent="handleSubmit(save)" novalidate>
                <dropdown-input
                    v-if="num !== 11"
                    v-model="form.num"
                    rules="required"
                    name="dialOption"
                    :label="verbage"
                    :options="dropDownList"
                ></dropdown-input>
                <dropdown-input
                    v-model="form.whatHappens"
                    rules="required"
                    name="whatHappens"
                    label="What Happens"
                    :options="whatHappensOptions"
                ></dropdown-input>
                <Transition>
                    <div v-if="form.whatHappens === 'Take Message' || form.whatHappens === 'Ring Phone(s)'">
                        <h5 class="text-center">For The Following Extensions</h5>
                        <div v-for="ext in form.targetExtension" :key="ext" class="text-center">
                            {{ext}}
                            <i class="fas fa-minus-circle text-danger pointer" title="Remove Extension" v-b-tooltip.hover @click="remExt(ext)"></i>
                        </div>
                        <div class="text-center">
                            Add Extension
                            <input type="text" v-model="addingExt" />
                            <b-button pill size="sm" variant="info" @click="addExt"><i class="fas fa-plus"></i></b-button>
                        </div>
                    </div>
                </Transition>
                <div class="text-center mt-3">
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
            num: {
                type: Number|String,
                required: true,
            },
            verbage: {
                type: String,
                required: true,
            },
            whatHappens: {
                type: String|null,
                required: true,
            },
            availableOptions: {
                type: Array,
                required: true,
            }
        },
        data() {
            return {
                form: {
                    num            : this.num,
                    wasOption      : this.num,
                    whatHappens    : this.whatHappens,
                    targetExtension: [],
                },
                addingExt: null,
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
        computed: {
            dropDownList()
            {
                let newList = [...this.availableOptions]
                if(newList.indexOf(this.num) === -1  && this.num !== '?')
                {
                    newList.push(this.num);
                }

                return newList.sort((a, b) => {return a - b});
            }
        },
        methods: {
            save()
            {
                this.$emit('save', this.form);
            },
            reset()
            {
                this.form.num             = this.num;
                this.form.whatHappens     = '';
                this.form.targetExtension = [];
            },
            addExt()
            {
                this.form.targetExtension.push(this.addingExt);
                this.addingExt = null;
            },
            remExt(ext)
            {
                let index = this.form.targetExtension.indexOf(ext);
                this.form.targetExtension.splice(index, 1);
            }
        },
    }
</script>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}
</style>
