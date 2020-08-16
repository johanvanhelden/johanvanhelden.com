<template>
    <section class="py-10">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-4xl text-center font-bold mb-6">
                Subscribe For Updates
            </h2>
            <p class="text-center mb-4">
                Would you like to receive an update when I release something new or when I have something to announce?
                <br>
                Simply fill in the form below with your name and email address, submit it, and I will send you an email!
            </p>

            <form @submit.prevent="submit">
                <div class="flex flex-wrap justify-center -mx-1 lg:-mx-4 mb-4">
                    <div class="my-1 px-1 w-full lg:my-4 lg:px-4 lg:w-2/6">
                        <input
                            v-model="form.name"
                            name="name"
                            type="text"
                            class="input"
                            placeholder="Enter your name"
                            required
                        >
                    </div>
                    <div class="my-1 px-1 w-full lg:my-4 lg:px-4 lg:w-2/6">
                        <input
                            v-model="form.email"
                            name="email"
                            type="email"
                            class="input"
                            placeholder="Enter your email"
                            required
                        >
                    </div>
                    <div class="my-1 px-1 w-full lg:my-4 lg:px-4 lg:w-1/6">
                        <button
                            type="submit"
                            class="w-full button button--primary"
                        >
                            Subscribe
                        </button>
                    </div>
                </div>
            </form>

            <PageErrors />

            <p class="text-center">
                If you change your mind later, no problem! In each email there will be an unsubscribe link.
            </p>
        </div>
    </section>
</template>

<script>
import PageErrors from './../../components/PageErrors';

export default {
    components: {
        PageErrors
    },
    /**
     * Add all the properties found in the data object to Vue’s reactivity system.
     *
     * @return {object}
     */
    data() {
        return {
            form: {
                name: null,
                email: null
            }
        };
    },
    methods: {
        /**
         * Handles the task create form submit
         */
        submit() {
            this.$inertia
                .post(route('subscriber.store'), this.form, {
                    preserveState: true,
                    preserveScroll: true
                })
                .then(() => {
                    if (Object.keys(this.$page.errors).length === 0) {
                        this.form.name = null;
                        this.form.email = null;
                    }
                });
        }
    }
};
</script>
