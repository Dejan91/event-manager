window._ = require('lodash');

try {
    window.Popper = require('popper.js').default;
    window.$ = window.jQuery = require('jquery');

    require('bootstrap');
} catch (e) {}

let Vue = require('vue');

window.Vue = Vue;

window.axios = require('axios');

window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

window.Vue.prototype.authorize = function (handler) {
    if (window.App.user.roles[0].name === 'Super Admin') {
        return true;
    }
    return handler(window.App.user);
};

window.events = new Vue();

window.flash = function (message, level = 'success') {
    window.events.$emit('flash', { message, level });
};

window.emailVerificationModal = function () {
    window.events.$emit('emailVerification');
};
