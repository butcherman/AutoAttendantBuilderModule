<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <h2 class="text-center">Auto Attendant Builder</h2>
            </div>
        </div>
        <div id="builder-wrapper" class="row justify-content-center p-4">
            <div class="col h-100">
                <div class="card h-100">
                    <div class="card-body h-100">
                        <div class="card-title text-center">
                            <inertia-link
                                v-if="auth"
                                as="b-button"
                                size="sm"
                                variant="info"
                                :href="route('dashboard')"
                                pill
                            >
                                Return to Tech Bench
                            </inertia-link>
                        </div>
                        <div class="row">
                            <div class="col-12 clearfix">
                                <h4 class="text-center text-dark grid-margin">Welcome</h4>
                                <div class="row justify-content-center grid-margin">
                                    <div class="col-md-6 text-center">
                                        <p>
                                            Welcome to the Auto Attendant Builder. The purpose of this tool is to assist in building a functional Auto Attendant Tree for your business.  Working through the different
                                            steps we can build a tree that ensures that the tree is user friendly and has all of the information necessary to efficiently route caller to the right people and departments.
                                        </p>
                                        <p>
                                            Select one of the options below to get started.
                                        </p>
                                    </div>
                                </div>
                                <div class="row justify-content-center grid-margin">
                                    <div class="col-md-3 text-right">
                                        <inertia-link as="b-button" :href="route('AutoAttendantBuilderModule.wizard')" block variant="info" pill>Start the Wizard</inertia-link>
                                    </div>
                                    <div class="col-md-4">
                                        <p>The Auto Attendant Wizard will walk you step by step through building your Auto Attendant Tree</p>
                                    </div>
                                </div>
                                <div class="row justify-content-center grid-margin">
                                    <div class="col-md-3 text-right">
                                        <b-button block variant="info" pill @click="comingSoon">Load Data File</b-button>
                                    </div>
                                    <div class="col-md-4">
                                        <p>If you previously downloaded a data file from this site you can upload it to continue working on your Auto Attendant Tree</p>
                                    </div>
                                </div>
                                <div class="row justify-content-center grid-margin">
                                    <div class="col-md-3 text-right">
                                        <inertia-link as="b-button" :href="route('AutoAttendantBuilderModule.create')" block variant="info" pill>I know what I'm doing, let me at it</inertia-link>
                                    </div>
                                    <div class="col-md-4">
                                        <p>No Wizard, no fluff.  Get right to building your Auto Attendant Tree</p>
                                    </div>
                                </div>
                                <div class="row justify-content-center grid-margin">
                                    <div class="col-md-3 text-right">
                                        <b-button block variant="info" pill @click="comingSoon">Tips and Tricks</b-button>
                                    </div>
                                    <div class="col-md-4">
                                        <p>Here are some tips to make your Auto Attendant user friendly</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            auth: {
                type: Boolean,
                default: false,
            }
        },
        data() {
            return {
                //
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
            comingSoon()
            {
                alert('Feature coming soon...');
            }
        },
    }
</script>
