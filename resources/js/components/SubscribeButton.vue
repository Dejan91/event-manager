<template>
    <div>
        <span class="fas fa-users"></span>
        <span v-text="subscribersCount"></span>
        <button @click="toggle" :class="classes" v-text="body"></button>
    </div>
</template>

<script>
export default {
    props: ['data'],

    data() {
        return {
            isSubscribed: this.data.isSubscribed,
            subscribersCount: this.data.subscribersCount
        };
    },

    computed: {
        classes() {
            return ['btn', this.isSubscribed ? 'btn-danger' : 'btn-primary'];
        },

        endpoint() {
            return `/event/${this.data.id}/subscription`;
        },

        body() {
            return this.isSubscribed ? 'Not Interested' : 'Interested';
        }
    },

    methods: {
        toggle() {
            this.isSubscribed ? this.unsubscribe() : this.subscribe();
        },

        subscribe() {
            axios.post(this.endpoint);

            this.isSubscribed = true;
            this.subscribersCount++;
        },

        unsubscribe() {
            axios.delete(this.endpoint);

            this.isSubscribed = false;
            this.subscribersCount--;
        }
    }
}
</script>