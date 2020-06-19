/* eslint-disable no-undef */
import Vue from 'vue';
window.Vue = Vue;
window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

let token = document.head.querySelector('meta[name="csrf-token"]');

if (token) {
    window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
}

/**
 * Bind the global helper functions to Vue for use inside the template parts.
 */
/* eslint-disable camelcase */
Vue.prototype.route = route;
/* eslint-enable camelcase */
