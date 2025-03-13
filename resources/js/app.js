import "./bootstrap";
import "../css/app.css"; // AFTER ALL THE STEPS, YOU NEED TO IMPLEMENT THIS TO RUN COMPLETELY.

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";

const updateDarkMode = () => {
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
};

updateDarkMode();

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', updateDarkMode);

createInertiaApp({
    resolve: (name) => {
        const pages = import.meta.glob("./Pages/**/*.vue", { eager: true });
        return pages[`./Pages/${name}.vue`];
    },
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .mount(el);
    },
});
