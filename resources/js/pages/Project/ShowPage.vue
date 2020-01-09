<template>
    <div>
        <section class="py-10 bg-white">
            <div class="max-w-3xl px-6 mx-auto">
                <div class="mb-6">
                    <div class="flex items-center">
                        <h1 class="text-4xl font-bold">
                            {{ project.name }}
                        </h1>
                    </div>
                    <p class="block text-xs uppercase text-gray-600">
                        <span class="block md:inline">
                            Published on {{ project.publish_at | date }}
                        </span>

                        <span
                            v-if="project.is_updated"
                            class="hidden md:inline"
                            :class="updateMetaClass"
                        >&bull;</span>

                        <span
                            v-if="project.is_updated"
                            class="block md:inline"
                            :class="updateMetaClass"
                        >
                            Latest update on {{ project.updated_at | date }}
                        </span>
                    </p>
                </div>
                <!-- eslint-disable vue/no-v-html -->
                <div
                    class="content mb-6"
                    v-html="compiledContent"
                />
                <!-- eslint-enable vue/no-v-html -->
                <p v-if="project.external_url">
                    <a
                        :href="project.external_url"
                        target="_blank"
                        rel="noopener noreferrer"
                        class="link link--primary"
                    >
                        <font-awesome-icon :icon="['fas', 'external-link-alt']" />
                        Visit the project
                    </a>
                </p>
            </div>
        </section>

        <SubscriptionPartial />

        <AboutPartial class="bg-white" />
    </div>
</template>

<script>
import Layout from '../../layouts/Main';
import marked from 'marked';
import AboutPartial from '../Partials/AboutPartial';
import SubscriptionPartial from '../Partials/SubscriptionPartial';

export default {
    name: 'Project',
    layout: Layout,
    components: {
        SubscriptionPartial,
        AboutPartial
    },
    props: {
        project: {
            type: Object,
            required: true
        }
    },
    computed: {
        /**
         * Processes mark down text.
         *
         * @param {string} content
         *
         * @return {string}
         */
        compiledContent() {
            let content = this.project.content;

            if (!content) {
                return;
            }

            return marked(content, { sanitize: true });
        },
        /**
         * Determines the update meta text classes.
         *
         * @return {string}
         */
        updateMetaClass() {
            if (this.project.is_recently_updated) {
                return 'font-semibold text-blue-800';
            }

            return '';
        }
    },
    /**
     * The reactive metainfo object.
     *
     * @return {object}
     */
    metaInfo() {
        return { title: this.project.name };
    }
};
</script>
