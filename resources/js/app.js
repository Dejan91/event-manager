require('./bootstrap');

Vue.component('comment', require('./components/Comment.vue').default);

const app = new Vue({
    el: '#app'
});