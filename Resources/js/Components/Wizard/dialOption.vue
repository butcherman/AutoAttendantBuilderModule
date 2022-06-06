<template>
    <div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <p>
                    Now that we know what the greeting should say, we need to determine what happens when
                    callers press the buttons they are told to press.  For each option below, define what
                    should happen to the call when that option is pressed.
                </p>
                <p>
                    The Time Out option is for when the caller does not press anything, but instead just stays
                    on the line. We need to know what to do with the call in this instance as well.
                </p>
                <p>
                    If you would like to add additional option, use the Add button to assign them.
                </p>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6">
                <all-dial-options-form :dialOptions="dialOptions"></all-dial-options-form>
            </div>
        </div>
    </div>
</template>

<script>
    import upperFirst         from 'lodash/upperFirst';
    import AllDialOptionsForm from '../Forms/allDialOptionsForm.vue';

    export default {
        components: { AllDialOptionsForm },
        props: {
            node: {
                type: Object,
                required: true,
            }
        },
        data() {
            return {
                dialOptions: [],
            }
        },
        created() {
            //
        },
        mounted() {
            this.dialOptions = this.findDialOptions(this.node.data.greeting);
        },
        computed: {
            //
        },
        watch: {
            //
        },
        methods: {
            save(data)
            {
                console.log(data);
            },
            /**
             * Find any verbage like "Press 1 for..." or "Dial 1 for..." to note a one key dial option
             */
            findDialOptions(greeting)
            {
                const regex  = /(press|dial) \d/gmi;
                let foundOpt = greeting.match(regex);

                //  The default option that is in every AA Tree is time out
                let dialOptions = [
                    {
                        optNum: 11,
                        verbage: 'Time Out',
                    }
                ];

                if(foundOpt != null)
                {
                    foundOpt.forEach(opt => {
                        let number = opt.match(/\d+/);
                        let verbage = opt.match(/(press|dial)/gmi);

                        dialOptions.push({
                            optNum: Number(number[0]),
                            verbage: upperFirst(verbage),
                        });
                    });
                }

                return dialOptions;
            }
        },
    }
</script>
