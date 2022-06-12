<template>
    <div>
        <div class="row justify-content-center">
            <div class="col">
                <h4 class="text-center">
                    Welcome
                </h4>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-6 text-center">
                <p>
                     Welcome to the Auto Attendant Builder. The purpose of this tool is to assist in building
                     a functional Auto Attendant Tree for your business.  Working through the different steps
                     we can build a menu tree that ensures that it is user friendly and has all of the information
                     necessary to efficiently route caller to the correct departments and employees.
                </p>
                <p>
                    Select one of the options below to get started.
                </p>
            </div>
        </div>
        <div class="row justify-content-center mt-2 pt-2 border-top">
            <div class="col-md-3 text-right">
                <inertia-link as="b-button" :href="route('AutoAttendantBuilderModule.wizard')" block variant="info">Start the Wizard</inertia-link>
            </div>
            <div class="col-md-4 d-none d-md-block">
                <p>
                    The Auto Attendant Wizard will walk you through the step by step process of building an Auto Attendant Tree.
                </p>
            </div>
        </div>
        <div class="row justify-content-center mt-2 pt-2">
            <div class="col-md-3 text-right">
                <inertia-link as="b-button" :href="route('AutoAttendantBuilderModule.tips')" block variant="info">Tips and Tricks</inertia-link>
            </div>
            <div class="col-md-4 d-none d-md-block">
                <p>
                   Here are some tips and common questions that will help you build an efficient and user friendly
                   Auto Attendant.
                </p>
            </div>
        </div>
        <div class="row justify-content-center mt-2 pt-2">
            <div class="col-md-3 text-right">
                <inertia-link as="b-button" :href="route('AutoAttendantBuilderModule.loadData')" block variant="info">Load Data File</inertia-link>
            </div>
            <div class="col-md-4 d-none d-md-block">
                <p>
                    If you have previously downloaded a data file from this tool, you can upload it and continue
                    to work on it.
                </p>
            </div>
        </div>
        <div class="row justify-content-center mt-2 pt-2">
            <div class="col-md-3 text-right">
                <inertia-link as="b-button" :href="route('AutoAttendantBuilderModule.create')" block variant="info">I know what I'm doing, let me at it</inertia-link>
            </div>
            <div class="col-md-4 d-none d-md-block">
                <p>
                    No Wizard, no fluff.  Get right to building your Auto Attendant Tree
                </p>
            </div>
        </div>
    </div>
</template>

<script>
    import guest from '../../../../../resources/js/Layouts/guest';
    import Layout from '../Template/Layout.vue';

    export default {
        layout: [ guest, Layout ],
        props: {
            //
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
            //
        },
    }
</script>
