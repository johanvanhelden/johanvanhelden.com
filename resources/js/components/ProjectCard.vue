<template>
    <div
        class="rounded overflow-hidden shadow-lg border-blue-800 border-t-4 bg-white text-base | px-6 py-4"
        :class="cardClasses"
        @click="visitProject()"
    >
        <div class="flex items-center mb-2">
            <span
                v-if="title"
                class="font-bold text-xl | mr-2"
                :class="titleClasses"
            >
                {{ title }}
            </span>

            <PrimaryBadge
                v-if="updated"
                text="Updated"
                class="ml-auto"
            />
        </div>
        <p
            v-if="text"
            class="text-gray-700 text-base"
        >
            {{ text }}
        </p>
    </div>
</template>

<script>
import PrimaryBadge from './PrimaryBadge';

export default {
    components: {
        PrimaryBadge
    },
    props: {
        updated: {
            type: Boolean,
            default: false
        },
        url: {
            type: String,
            default: null
        },
        title: {
            type: String,
            default: null
        },
        text: {
            type: String,
            default: null
        }
    },
    computed: {
        /**
         * Determines the card's classes.
         *
         * @return {string}
         */
        cardClasses() {
            if (!this.url) {
                return '';
            }

            return 'hover:cursor-pointer hover:bg-gray-200';
        },

        /**
         * Determines the title's classes.
         *
         * @return {string}
         */
        titleClasses() {
            if (!this.url) {
                return '';
            }

            return 'link link--primary';
        }
    },
    methods: {
        /**
         * Visits the project's URL.
         */
        visitProject() {
            if (!this.url) {
                return;
            }

            this.$inertia.visit(this.url);
        }
    }
};
</script>
