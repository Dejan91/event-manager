<template>
    <div class="alert alert-success alert-flash" role="alert" v-show="show">
        {{ body }}
        <i class="fas fa-check-circle ml-1"></i>
    </div>
</template>

<script>
export default {
    props: ['message', 'type'],

    data() {
        return {
            body: '',
            show: false
        }
    },

    created() {
        if (this.message) {
            this.flash(this.message);
        }

        window.events.$on('flash', message => this.flash(message));
    },

    methods: {
        flash(message) {
            this.body = message;
            this.show = true;

            this.hide();
        },

        hide() {
            setTimeout(() => {
                this.show = false;
            }, 4000);
        }
    }
}
</script>

<style scoped>
    .alert-flash {
        position: fixed;
        right: 30px;
        bottom: 30px;
        font-size: 20px;
    }
</style>