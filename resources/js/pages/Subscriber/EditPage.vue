<template>
    <div>
        <section class="py-10 bg-white">
            <div class="max-w-3xl mx-auto px-6">
                <h2 class="text-4xl text-center font-bold mb-6">
                    {{ subscriber.name }}
                </h2>
                <p class="content text-center mb-6">
                    Here you can either edit your subscription information or unsubscribe.
                </p>
                <form @submit.prevent="submit">
                    <div class="mb-4">
                        <label
                            for="email"
                            class="input-label"
                        >Name</label>
                        <input
                            v-model="form.name"
                            name="name"
                            type="text"
                            class="input"
                            placeholder="Enter your name"
                            required
                        >
                    </div>
                    <div class="mb-4">
                        <label
                            for="email"
                            class="input-label"
                        >Email address</label>
                        <input
                            v-model="form.email"
                            name="email"
                            type="email"
                            class="input"
                            placeholder="Enter your email"
                        >
                    </div>
                    <div class="mb-4">
                        <button
                            type="submit"
                            class="w-full button button--primary"
                        >
                            Save
                        </button>
                    </div>
                </form>

                <PageErrors />

                <hr class="mb-4">

                <div class="mb-4">
                    <button
                        class="button text-xs"
                        @click="destroy"
                    >
                        Unsubscribe
                    </button>
                </div>

                <p
                    v-if="$page.succes == 'true'"
                    class="text-blue-800 text-center mb-4"
                >
                    You have succesfully edited your subscription!
                </p>
            </div>
        </section>
    </div>
</template>

<script>
import Layout from '../../layouts/Main';
import PageErrors from './../../components/PageErrors';

export default {
    name: 'Project',
    layout: Layout,
    components: {
        PageErrors
    },
    props: {
        subscriber: {
            type: Object,
            required: true
        }
    },
    /**
     * Add all the properties found in the data object to Vue’s reactivity system.
     *
     * @return {object}
     */
    data() {
        return {
            form: {
                name: this.subscriber.name,
                email: this.subscriber.email
            }
        };
    },
    methods: {
        /**
         * Handles the task create form submit
         */
        submit() {
            this.$inertia.put(route('subscriber.update', this.subscriber), this.form, {
                preserveState: true,
                preserveScroll: true
            });
        },
        /**
         * Handles the task create form submit
         */
        destroy() {
            this.$inertia.delete(route('subscriber.destroy', this.subscriber));
        }
    },
    /**
     * The reactive metainfo object.
     *
     * @return {object}
     */
    metaInfo() {
        return { title: 'Subscription management' };
    }
};
</script>
