import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';

const pages = import.meta.glob('./Pages/**/*.vue', { eager: true });

createInertiaApp({
    resolve: name => {
        const page = pages[`./Pages/${name}.vue`];

        if (!page) {
            throw new Error(`Página não encontrada: ${name}`);
        }

        return page.default;
    },

    setup({ el, App, props, plugin }) {
        createApp({
            render: () => h(App, props),
        })
            .use(plugin)
            .mount(el);
    },
});