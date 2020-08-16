<template>
    <div>
        <IntroPartial class="bg-white" />

        <ProjectsPartial :projects="projects" />

        <ToolsPartial
            :tools="tools"
            class="bg-white"
        />

        <LanguagesPartial />

        <AboutPartial class="bg-white" />

        <SubscriptionPartial />
    </div>
</template>

<script>
import Layout from '../layouts/Main';
import IntroPartial from './Partials/IntroPartial';
import ProjectsPartial from './Partials/ProjectsPartial';
import ToolsPartial from './Partials/ToolsPartial';
import LanguagesPartial from './Partials/LanguagesPartial';
import AboutPartial from './Partials/AboutPartial';
import SubscriptionPartial from './Partials/SubscriptionPartial';

export default {
    name: 'Home',
    layout: Layout,
    components: {
        IntroPartial,
        ProjectsPartial,
        ToolsPartial,
        LanguagesPartial,
        AboutPartial,
        SubscriptionPartial
    },
    props: {
        projects: {
            type: Array,
            default: null
        },
        tools: {
            type: Array,
            default: null
        }
    },
    /**
     * The reactive metainfo object.
     *
     * @return {object}
     */
    metaInfo() {
        return { title: 'Home' };
    }
};
</script>
