<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="far fa-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
export default {
    props: ['model', 'instance'],

    data() {
        return {
            favoritesCount: this.model.favoritesCount,
            isFavorited: this.model.isFavorited
        }
    },

    computed: {
        classes() {
            return ['btn', this.isFavorited ? 'btn-primary' : 'btn-outline-secondary'];
        },

        endpoint() {
            return `/favorite/${this.instance}/${this.model.id}`;
        }
    },

    methods: {
        toggle() {
            this.isFavorited ? this.unfavorite() : this.favorite();
        },

        favorite() {
            axios.post(this.endpoint)
                .then(() => console.log('Favourited'))
                .catch(error => {
                    if (this.verificationEmailError(error)) {
                        emailVerificationModal();
                    }
                });

                this.isFavorited = true;
                this.favoritesCount++;
        },

        unfavorite() {
            axios.delete(this.endpoint)
                .then(() => console.log('Unfavourited'))
                .catch(error => {
                    if (this.verificationEmailError(error)) {
                        emailVerificationModal();
                    }
                });

            this.isFavorited = false;
            this.favoritesCount--;
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
