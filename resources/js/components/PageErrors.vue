<template>
    <div
        v-if="Object.keys($page.errors).length"
        class="text-center"
    >
        <p
            v-for="(error, index) in $page.errors"
            :key="index"
            class="text-red-500 italic mb-4"
        >
            {{ error[0] }}
        </p>
    </div>
</template>

<script>
export default {};
</script>
