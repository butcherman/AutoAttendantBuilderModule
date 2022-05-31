<template>
    <div>
        <ValidationObserver v-slot="{handleSubmit, reset}">
            <b-form @submit.prevent="handleSubmit(save)" @reset.prevent="reset" novalidate>
                <dropdown-input
                    v-if="num !== 11"
                    v-model="form.dialOption"
                    rules="required"
                    name="dialOption"
                    :label="verbage"
                    :options="availableOptions"
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
                    <b-button pill variant="danger" type="reset">Reset</b-button>
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
            availableOptions: {
                type: Array,
                required: true,
            }
        },
        data() {
            return {
                form: {
                    dialOption     : this.num,
                    wasOption      : this.num,
                    whatHappens    : null,
                    targetExtension: [],
                },
                addingExt: null,
                whatHappensOptions: [
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
