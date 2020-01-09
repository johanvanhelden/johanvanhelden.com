<template>
    <a
        class="w-full | block | rounded text-base text-center | px-6 py-4"
        :class="cardClasses"
        :href="externalUrl || false"
        rel="noopener noreferrer"
        :target="externalUrl ? '_blank' : false"
    >
        <div
            class="h-24 mb-4 bg-contain bg-no-repeat"
            style="background-position: center center;"
            :style="{ backgroundImage: 'url(' + imageUrl + ')' }"
        />
        <div class="font-bold text-xl mb-2 text-center">
            {{ name }}
        </div>
    </a>
</template>

<script>
export default {
    props: {
        name: {
            type: String,
            required: true
        },
        imageUrl: {
            type: String,
            required: true
        },
        externalUrl: {
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
            if (!this.externalUrl) {
                return 'hover:cursor-default';
            }

            return 'link link--primary hover:bg-gray-200';
        }
    }
};
</script>
