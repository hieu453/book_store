import '../css/app.css';
import './bootstrap';
import 'primeicons/primeicons.css'
import "quill/dist/quill.snow.css";

import { createInertiaApp } from '@inertiajs/vue3';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import PrimeVue from 'primevue/config';
import Aura from '@primevue/themes/aura';
import ToastService from 'primevue/toastservice';
import HomeLayout from './Layouts/HomeLayout.vue';
import formatCurrency from './helper/formatCurrency';

import dayjs from 'dayjs';
import 'dayjs/locale/vi';
import relativeTime from 'dayjs/plugin/relativeTime'

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })
        let page = pages[`./Pages/${name}.vue`]
        page.default.layout = name.startsWith('Admin/') ? undefined : HomeLayout
        return page
    },
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(PrimeVue, {
                theme: {
                    preset: Aura,

                },
            })
            .use(dayjs.extend(relativeTime))
            .use(ToastService)
            .use(formatCurrency)
            .mount(el);
    },
    progress: {
        color: 'red',
    },
});
