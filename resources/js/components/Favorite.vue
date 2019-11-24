<template>
    <button type="submit" :class="classes" @click="toggle">
        <span class="far fa-heart"></span>
        <span v-text="favoritesCount"></span>
    </button>
</template>

<script>
export default {
    props: ['comment'],

    data() {
        return {
            favoritesCount: this.comment.favoritesCount,
            isFavorited: this.comment.isFavorited
        }
    },

    computed: {
        classes() {
            return ['btn', this.isFavorited ? 'btn-primary' : 'btn-outline-secondary'];
        },

        endpoint() {
            return "/favorite/comment/" + this.comment.id;
        }
    },

    methods: {
        toggle() {
            this.isFavorited ? this.unfavorite() : this.favorite();
        },

        favorite() {
            axios.post(this.endpoint)
                .then()
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
                .then()
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