<template>
    <section class="py-10">
        <div class="max-w-5xl mx-auto px-6">
            <h2 class="text-5xl text-center font-bold mb-6">
                In The Toolbox
            </h2>
            <div class="flex flex-wrap items-center justify-center">
                <ToolCard
                    v-for="(tool, index) in tools"
                    :key="index"
                    :name="tool.name"
                    :image-url="tool.image_url"
                    :external-url="tool.external_url"
                    class="w-full sm:w-1/2 md:w-1/3 lg:w-1/4"
                />
            </div>
        </div>
    </section>
</template>

<script>
import ToolCard from '../../components/ToolCard';

export default {
    components: {
        ToolCard
    },
    props: {
        tools: {
            type: Array,
            default: null
        }
    }
};
</script>
