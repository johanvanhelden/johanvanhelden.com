<template>
    <div
        class="alert | border-solid border-2 text-center text-base | py-2 px-4"
        :class="alertClasses"
    >
        <label
            class="close cursor-pointer flex items-center justify-between w-full p-2"
            title="close"
            @click.prevent="dismiss()"
        >
            {{ message }}

            <svg
                class="fill-current text-blue-800"
                xmlns="http://www.w3.org/2000/svg"
                width="18"
                height="18"
                viewBox="0 0 18 18"
            >
                <path
                    d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"
                />
            </svg>
        </label>
    </div>
</template>

<script>
export default {
    props: {
        message: {
            type: String,
            required: true
        },
        level: {
            type: String,
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
            dismissed: false
        };
    },
    computed: {
        /**
         * Determines the alert classes.
         *
         * @return {string}
         */
        alertClasses() {
            let classes = '';

            if (this.dismissed) {
                classes += 'dismissed ';
            }

            if (this.level == 'info') {
                classes += 'bg-blue-200 text-blue-800 border-blue-800 ';
            }

            if (this.level == 'success') {
                classes += 'bg-green-200 text-green-800 border-green-800 ';
            }

            if (this.level == 'error') {
                classes += 'bg-red-200 text-red-800 border-red-800 ';
            }

            return classes;
        }
    },
    watch: {
        '$page.flashNotifications': {
            handler() {
                this.dismissed = false;
            },
            deep: true
        }
    },
    methods: {
        /**
         * Dismisses the alert.
         */
        dismiss() {
            this.dismissed = true;
        }
    }
};
</script>
