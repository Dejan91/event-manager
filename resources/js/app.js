require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('emailVerificationModal', require('./components/Modal.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('events', require('./components/Events.vue').default);

Vue.component('event-view', require('./pages/Event.vue').default);

const app = new Vue({
    el: '#app'
});


