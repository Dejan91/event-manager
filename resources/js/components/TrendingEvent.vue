<template>
    <li class="list-group-item">
        <a :href="event.path">
            {{ event.title }}
        </a>
    </li>
</template>

<script>
export default {
    props: ['data'],

    data() {
        return {
            event: this.data
        }
    }
}
</script>