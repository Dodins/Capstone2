import "./bootstrap";
import "../css/app.css"; // AFTER ALL THE STEPS, YOU NEED TO IMPLEMENT THIS TO RUN COMPLETELY.

import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/vue3";
import { resolvePageComponent } from "laravel-vite-plugin/inertia-helpers";
import { ZiggyVue } from "../../vendor/tightenco/ziggy";

const appName = import.meta.env.VITE_APP_NAME || "Laravel";

const updateDarkMode = () => {
    if (window.matchMedia("(prefers-color-scheme: dark)").matches) {
        document.documentElement.classList.add("dark");
    } else {
        document.documentElement.classList.remove("dark");
    }
};

updateDarkMode();

window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", updateDarkMode);

const getProgressColor = () => {
    return window.matchMedia("(prefers-color-scheme: dark)").matches
        ? "#6084FF" // Light blue for dark mode
        : "#3B5FBF"; // Default gray for light mode
};

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob("./Pages/**/*.vue")
        ),
    setup({ el, App, props, plugin }) {
        createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: getProgressColor(),
    },
});
