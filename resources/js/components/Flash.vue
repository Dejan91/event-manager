<template>
    <div class="alert alert-flash" :class="'alert-'+level" role="alert" v-show="show">
        {{ body }}
    </div>
</template>

<script>
export default {
    props: ['message', 'type'],

    data() {
        return {
            body: '',
            level: 'success',
            show: false
        }
    },

    created() {
        if (this.message) {
            this.flash(this.message);
        }

        window.events.$on('flash', data => this.flash(data));
    },

    methods: {
        flash(data) {
            this.body = data.message;
            this.level = data.level;
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
