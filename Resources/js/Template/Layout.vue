<template>
    <div class="h-100">
        <div class="row">
            <div class="col mt-4">
                <h2 class="text-center">Auto Attendant Builder</h2>
            </div>
        </div>
        <div class="row m-md-4 m-1">
            <div class="col">
                <div id="builder-wrapper" class="card">
                    <div class="card-body">
                        <div class="card-title">
                            <b-nav>
                                <inertia-link as="b-nav-item" :href="route('AutoAttendantBuilderModule.index')">Home</inertia-link>
                                <inertia-link as="b-nav-item" :href="route('AutoAttendantBuilderModule.wizard')">Wizard</inertia-link>
                                <inertia-link as="b-nav-item" :href="route('AutoAttendantBuilderModule.create')">AA Builder</inertia-link>
                                <inertia-link as="b-nav-item" :href="route('AutoAttendantBuilderModule.tips')">Tips and Tricks</inertia-link>
                                <inertia-link as="b-nav-item" :href="route('AutoAttendantBuilderModule.loadData')">Load Data File</inertia-link>
                                <inertia-link as="b-nav-item" :href="route('dashboard')" v-if="auth">Return to Tech Bench</inertia-link>
                            </b-nav>
                        </div>
                        <slot />
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
                required: true,
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
            //
        },
    }
</script>
