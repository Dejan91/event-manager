<template>
    <div>
        <span class="fas fa-users"></span>
        <span v-text="subscribersCount"></span>
        <span class="mr-2"></span>
        <button @click="toggle" :class="classes">Interested</button>
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
            return ['btn', this.isSubscribed ? 'btn-primary' : 'btn-outline-primary'];
        },

        endpoint() {
            return `/event/${this.data.id}/subscription`;
        }
    },

    methods: {
        toggle() {
            this.isSubscribed ? this.unsubscribe() : this.subscribe();
        },

        subscribe() {
            axios.post(this.endpoint)
                .then()
                .catch(error => {
                    if (this.verificationEmailError(error)) {
                        emailVerificationModal();
                    }
                });
            this.isSubscribed = true;
            this.subscribersCount++;
        },

        unsubscribe() {
            axios.delete(this.endpoint)
                .then()
                .catch(error => {
                    console.log(error);
                });
            this.isSubscribed = false;
            this.subscribersCount--;
        },

        verificationEmailError(error) {
            if (error.response.data.message === "Your email address is not verified.") {
                return true;
            }
            return false;
        }
    }
}
</script>
