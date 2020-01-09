<template>
    <div>
        <section class="py-10 bg-white">
            <h2 class="text-2xl text-center font-bold mb-6">
                {{ message }}
            </h2>
        </section>
        <section class="py-10">
            <div class="text-center">
                <inertia-link
                    class="link link--primary"
                    :href="route('page.home')"
                >
                    Go back
                </inertia-link>
            </div>
        </section>
    </div>
</template>

<script>
import Layout from '../layouts/Main';
import { errorMessage } from '../helpers/message.js';

export default {
    layout: Layout,
    props: {
        status: {
            type: Number,
            required: true
        }
    },
    computed: {
        /**
         * Determines the error message based on the status code.
         *
         * @return {string}
         */
        message() {
            return errorMessage(this.status);
        }
    },
    /**
     * The reactive metainfo object.
     *
     * @return {object}
     */
    metaInfo() {
        return {
            title: this.message
        };
    }
};
</script>
