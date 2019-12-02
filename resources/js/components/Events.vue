<template>
    <div class="container">
        <div class="row">
            <advanced-search @filtered="rerender"></advanced-search>
            <div class="[ col-xs-12 col-sm-offset-2 col-sm-8 ]">
                <ul class="event-list" v-for="event in items" :key="event.id">
                    <single-event :data="event"></single-event>
                </ul>
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

        rerender(data) {
            this.items = data;
        }
    }
}
</script>
