import './bootstrap';
import '../css/app.css';
import 'vue-multiselect/dist/vue-multiselect.min.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy/dist/vue.m';
import Multiselect from "@suadelabs/vue3-multiselect";
import MultiSelectDropdown from './Components/MultiSelectDropdown.vue';
import VueUploadComponent from 'vue-upload-component'

const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue, Ziggy)
            .component('Multiselect', Multiselect)
            .component('MultiSelectDropdown', MultiSelectDropdown)
            .component('file-upload', VueUploadComponent)
            .mixin({
                methods: {
                    userHasRole(...roles) {
                        return roles.includes(this.$page.props.auth.user.role);
                    }
                }
            })
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});

