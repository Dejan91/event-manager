<template>
    <div class="container">
        <div class="row">
            <advanced-search @filtered="rerender"></advanced-search>
        </div>
        <div class="row">
            <div class="col-sm-12 col-md-8">
                <div class="row">
                    <single-event
                        v-for="event in items"
                        :data="event"
                        :key="event.id">
                    </single-event>
                </div>
            </div>
            <div class="col-sm-12 col-md-4">
                <div class="card">
                    <div class="card-header">
                        Trending Events
                    </div>
                    <div class="card-body">
                        <trending-event 
                            v-for="trending in trendings" 
                            :key="trending.path"
                            :data="trending">
                        </trending-event>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import AdvancedSearch from '../components/AdvancedSearch';
import SingleEvent from './SingleEvent';
import TrendingEvent from './TrendingEvent';

export default {
    components: { AdvancedSearch, SingleEvent, TrendingEvent },

    data() {
        return {
            items: [],
            trendings: [],
        }
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch() {
            axios.get('/event')
                .then((data) => {
                    this.items = data.data.events;
                    this.trendings = data.data.trending;
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

<style scoped>
    .card {
        margin-top: 20px;
    }
</style>
