import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import postcss from "postcss";
import tailwindcss from "tailwindcss";
import autoprefixer from "autoprefixer";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
    ],
    css: {
        postcss: {
            plugins: [tailwindcss("./tailwind.config.js"), autoprefixer],
        },
    },
});
