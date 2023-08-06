import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import { splitVendorChunkPlugin } from "vite";

const defaultConfig = {
    plugins: [
        splitVendorChunkPlugin(),
        laravel({
            input: ["resources/css/main.css", "resources/src/main.js"],
            refresh: true,
        }),
    ],
    build: {
        chunkSizeWarningLimit: 1000,
    },
};

export default defineConfig(({ command, mode }) => {
    if (command === "serve" && mode === "test") {
        return {
            ...defaultConfig,
            test: {
                globals: true,
                root: "resources/src/",
            },
        };
    }

    return {
        ...defaultConfig,
    };
});
