<template>
    <li class="nav-item dropdown" v-if="notifications.length" >
        <a class="nav-link dropdown" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fas fa-bell fa-lg"></i>
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a v-for="notification in notifications"
               class="dropdown-item"
               :href="notification.data.link"
               v-text="notification.data.message"
               @click="markAsRead(notification)">
            </a>
        </div>
    </li>
</template>

<script>
    export default {
        name: "UserNotifications.vue",

        data() {
            return {
                notifications: false
            }
        },

        created() {
            axios.get('/users/' + window.App.user.id + '/profile/notifications')
                .then(response => this.notifications = response.data);
        },

        methods: {
            markAsRead(notification) {
                axios.delete('/users/' + window.App.user.id + '/profile/notifications/' + notification.id);
            }
        }
    }
</script>

<style scoped>

</style>
