<template>
    <div class="alert alert-flash"
         :class="'alert-'+level"
         role="alert"
         v-show="show"
         v-text="body">
    </div>
</template>

<script>
export default {
    props: ['message', 'type'],

    data() {
        return {
            body: this.message,
            level: 'success',
            show: false
        }
    },

    created() {
        if (this.message) {
            this.flash();
        }

        window.events.$on('flash', data => this.flash(data));
    },

    methods: {
        flash(data) {
            if (data) {
                this.body = data.message;
                this.level = data.level;
            }

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
