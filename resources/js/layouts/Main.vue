<template>
    <div class="min-h-screen flex flex-col font-sans text-xl text-gray-700 antialiased border-t-4 border-blue-800">
        <div class="flex-grow">
            <div v-if="$page.flashNotifications && $page.flashNotifications.length > 0">
                <FlashMessage
                    v-for="(notification, fieldIndex) in $page.flashNotifications"
                    :key="fieldIndex"
                    :message="notification.message"
                    :level="notification.level"
                    class="w-1/3 fixed top-0 right-0 z-50 | mt-4 mr-4"
                />
            </div>

            <Header />
            <main>
                <slot />
            </main>
        </div>
        <Footer />
    </div>
</template>

<script>
import Header from '../components/Header';
import Footer from '../components/Footer';
import FlashMessage from '../components/FlashMessage';

export default {
    components: {
        Header,
        Footer,
        FlashMessage
    }
};
</script>
