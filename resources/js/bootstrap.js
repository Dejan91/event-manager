window._ = require('lodash');

let Vue = require('vue');

window.Vue = Vue;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.events = new Vue();

window.flash = function (message) {
    window.events.$emit('flash', message);
};