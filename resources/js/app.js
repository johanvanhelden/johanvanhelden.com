/* eslint-disable no-undef */
import './bootstrap';

import Vue from 'vue';
import { InertiaApp } from '@inertiajs/inertia-vue';

import axios from 'axios';
import Meta from 'vue-meta';
import VueScrollTo from 'vue-scrollto';
import VueMoment from 'vue-moment';

import './icons.js';

/**
 * Localize DayJS.
 */
import dayjs from 'dayjs';
import * as daysjsEN from 'dayjs/locale/en-gb';
import { date } from './helpers/datetime';

dayjs.locale(daysjsEN);

Vue.http = Vue.prototype.$http = axios;
Vue.config.productionTip = false;

Vue.use(InertiaApp);
Vue.use(Meta);
Vue.use(VueScrollTo);
Vue.use(VueMoment);

/**
 * Initialize Vue filters.
 */
Vue.filter('date', date);

const app = document.getElementById('app');
const files = require.context('./', true, /\.vue$/i);

if (app) {
    new Vue({
        /**
         * The reactive metainfo object.
         *
         * @return {object}
         */
        metaInfo() {
            return {
                title: 'Loading...',
                titleTemplate: '%s - ' + 'Johan van Helden'
            };
        },
        render: h =>
            h(InertiaApp, {
                props: {
                    initialPage: JSON.parse(app.dataset.page),
                    resolveComponent: page => files(`./pages/${page}Page.vue`).default
                }
            })
    }).$mount(app);
}
