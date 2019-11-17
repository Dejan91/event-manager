require('./bootstrap');

Vue.component('flash', require('./components/Flash.vue').default);
Vue.component('comment', require('./components/Comment.vue').default);

const app = new Vue({
    el: '#app'
});