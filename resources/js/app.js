// resources/js/app.js
require("./bootstrap");


import { createApp, h } from "vue";
import { createInertiaApp } from "@inertiajs/inertia-vue3";
import { InertiaProgress } from "@inertiajs/progress";
import VueSweetalert2 from 'vue-sweetalert2';
import 'sweetalert2/dist/sweetalert2.min.css';
import store from './store';
import { TailwindPagination } from 'laravel-vue-pagination';

// import VueMultiselect from 'vue-multiselect'



const appName =
    window.document.getElementsByTagName("title")[0]?.innerText || "Laravel";

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({ render: () => h(app, props) })
            .use(plugin)
            .mixin({ methods: { route }})
            // .mixin({ components: {VueMultiselect}})
            .use(VueSweetalert2)
            .use(TailwindPagination)
            .use(store)
            .mount(el);
    },
});

InertiaProgress.init({ color: "#4B5563" });