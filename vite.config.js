import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";

export default defineConfig({
    plugins: [
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
    theme: {
        extend: {
            gridTemplateRows: {
                "[auto,auto,1fr]": "auto auto 1fr",
            },
        },
    },
});
