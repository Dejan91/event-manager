<template>
    <div class="container">
        <div class="row">
            <advanced-search @filtered="rerender"></advanced-search>

            <div class="row">
                <single-event 
                    v-for="event in items" 
                    :data="event" 
                    :key="event.id">
                </single-event>
            </div>
        </div>
    </div>
</template>

<script>
import AdvancedSearch from '../components/AdvancedSearch';
import SingleEvent from "./SingleEvent";

export default {
    components: { AdvancedSearch, SingleEvent },

    data() {
        return {
            items: []
        }
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            axios.get('/event')
                .then(({ data }) => {
                    this.items = data;
                })
                .catch(error => {
                    alert(error);
                });
        },

        rerender(events) {
            this.items = events;
        }
    }
}
</script>
