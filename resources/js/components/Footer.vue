<template>
    <div class="bg-gray-800 text-white">
        <div class="sm:flex max-w-6xl mx-auto px-6 py-8">
            <div class="sm:flex-1 text-center sm:text-left mb-6 sm:mb-0">
                <inertia-link href="/">
                    Johan van Helden
                </inertia-link>
                © {{ new Date().getFullYear() }}
            </div>
            <div class="sm:flex-1 text-center sm:text-right">
                <a
                    href="mailto:johan@johanvanhelden.com"
                    rel="noopener noreferrer"
                    target="_blank"
                    class="mx-2"
                >
                    <font-awesome-icon :icon="['far', 'envelope']" />
                </a>
                <a
                    href="https://github.com/johanvanhelden"
                    rel="noopener noreferrer"
                    target="_blank"
                    class="mx-2"
                >
                    <font-awesome-icon :icon="['fab', 'github']" />
                </a>
                <a
                    href="https://www.twitter.com/johanvhelden"
                    rel="noopener noreferrer"
                    target="_blank"
                    class="mx-2"
                >
                    <font-awesome-icon :icon="['fab', 'twitter']" />
                </a>
                <a
                    href="https://www.linkedin.com/in/johanvhelden"
                    rel="noopener noreferrer"
                    target="_blank"
                    class="mx-2"
                >
                    <font-awesome-icon :icon="['fab', 'linkedin']" />
                </a>
            </div>
        </div>
    </div>
</template>

<script>
export default {};
</script>
