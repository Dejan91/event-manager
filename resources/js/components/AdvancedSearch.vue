<template>
    <form class="mt-3 mb-3" action="" method="GET">
        <div class="row">
            <div class="form-group mr-2">
                <label for="start">Start</label>
                <input type="date" class="form-control" v-model="start" id="start" placeholder="Start">
            </div>
            <div class="form-group mr-2">
                <label for="end">End</label>
                <input type="date" class="form-control" v-model="end" id="end" placeholder="End">
            </div>
        </div>
        <div class="row">
            <div class="form-group mr-2">
                <input type="text" class="form-control" v-model="title" id="title" placeholder="Title">
            </div>
            <div class="form-group mr-2">
                <input type="text" class="form-control" v-model="description" id="description" placeholder="Description">
            </div>
            <div class="form-group mr-2">
                <input type="text" class="form-control" v-model="country" id="country" placeholder="Country">
            </div>
            <div class="form-group">
                <button @click.prevent="submitSearch" type="submit" id="search" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            start: '',
            end: '',
            title: '',
            description: '',
            country: ''
        };
    },


    methods: {
        submitSearch() {
            let startDate = '';
            let endDate = '';

            if (this.start) {
                startDate = moment(this.start).format('DD-MM-YYYY');
            }

            if (this.end) {
                endDate = moment(this.end).format('DD-MM-YYYY');
            }

            window.location = "/event"
                +"?title="+this.title
                +"&description="+this.description
                +"&country="+this.country
                +"&start="+startDate
                +"&end="+endDate;
        }
    }
}
</script>
