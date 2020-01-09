<template>
    <span class="bg-blue-800 text-blue-100 text-white text-xs uppercase font-semibold | inline-block | px-2 | rounded">
        {{ text }}
    </span>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        }
    }
};
</script>
