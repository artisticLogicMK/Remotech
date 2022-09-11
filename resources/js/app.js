import './bootstrap'

import { createApp, h, onMounted } from 'vue'
import store from './Store'
import VWave from 'v-wave'
import { createInertiaApp, Link, Head } from '@inertiajs/inertia-vue3'
import { InertiaProgress } from '@inertiajs/progress'
import 'aos/dist/aos.css'

const appName = window.document.getElementsByTagName('title')[0]?.innerText || 'Remotech'

const elm = document.getElementById('app');

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => require(`./Pages/${name}.vue`),
    setup({ el, app, props, plugin }) {
        return createApp({
            setup() {
                onMounted(() => {
                    delete elm.dataset.page
                })
            },
            render: () => h(app, props) })
            .use(plugin)
            .use(store)
            .use(VWave)
            .component('Link', Link)
            .component('Head', Head)
            .mixin({ methods: { route } })
            .mount(el);
    },
});

InertiaProgress.init({ color: '#4B5563', showSpinner: true });
