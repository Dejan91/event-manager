require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('emailVerificationModal', require('./components/Modal.vue').default);
Vue.component('paginator', require('./components/Paginator.vue').default);
Vue.component('rangePicker', require('./components/RangePicker.vue').default);
Vue.component('advancedSearch', require('./components/AdvancedSearch.vue').default);
Vue.component('singleEvent', require('./components/SingleEvent.vue').default);
Vue.component('events', require('./components/Events.vue').default);

Vue.component('event-view', require('./pages/Event.vue').default);

const app = new Vue({
    el: '#app'
});


