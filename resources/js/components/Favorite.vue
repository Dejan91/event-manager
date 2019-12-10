<template>
    <div class="d-inline" @click="toggle">
        <span :class="classes" id="heart"></span>
        <span v-text="favoritesCount" id="count"></span>
    </div>
</template>

<script>
export default {
    props: ['model', 'instance', 'size'],

    data() {
        return {
            favoritesCount: this.model.favoritesCount,
            isFavorited: this.model.isFavorited,
            favoriteSize: this.size,
        }
    },

    computed: {
        classes() {
            return [this.isFavorited ? 'fas' : 'far', 'fa-heart', this.favoriteSize];
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

<style scoped>
    #heart {
        color: #3490dc;
    }

    #count {
        color: rgb(66, 66, 66);
    }

    div:hover {
        cursor: pointer;
    }
</style>
