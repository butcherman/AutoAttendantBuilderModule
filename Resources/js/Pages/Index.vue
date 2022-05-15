<template>
    <div>
        <div class="row">
            <div class="col-12 mt-4">
                <h1 class="text-center">Auto Attendant Builder</h1>
            </div>
        </div>
        <div class="row justify-content-center mx-2">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title text-center" v-if="auth"><inertia-link as="b-button" size="sm" pill :href="route('dashboard')" variant="info">Return to Tech Bench</inertia-link></div>
                        <div class="row builder-diagram">
                            <div class="col-md-8 border"></div>
                            <div class="col-md-4 border"></div>
                        </div>
                        <div class="row builder-data">
                            <div class="col border">something....</div>
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
                type:    Boolean,
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
            //
        },
    }
</script>

<style>
    .builder-diagram {
        height: 65vh;
    }
    .builder-data {
        min-height: 10vh;
    }
</style>
