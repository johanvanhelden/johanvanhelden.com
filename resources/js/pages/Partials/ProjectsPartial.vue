<template>
    <section
        v-if="projects"
        class="py-10"
    >
        <div class="max-w-6xl mx-auto px-6">
            <h2 class="text-4xl text-center font-bold mb-6">
                Projects
            </h2>
            <div class="flex flex-wrap">
                <ProjectCard
                    v-for="(project, index) in projects"
                    :key="index"
                    :title="project.name"
                    :text="project.excerpt"
                    :updated="project.is_recently_updated"
                    :url="route('project.show', { project: project.slug })"
                    class="mx-2 my-3 px-3 w-full md:flex-grow md:w-1/3 lg:w-1/4"
                />
            </div>
        </div>
    </section>
</template>

<script>
import ProjectCard from '../../components/ProjectCard';

export default {
    components: {
        ProjectCard
    },
    props: {
        projects: {
            type: Array,
            default: null
        }
    }
};
</script>
