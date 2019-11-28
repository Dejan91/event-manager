<template>
    <form class="mt-3 mb-3 ml-3" action="" method="GET">
        <div class="row">
            <div class="form-group mr-2">
                <label for="start">Start</label>
                <input type="date" class="form-control" v-model="start" id="start" placeholder="Start">
            </div>
            <div class="form-group mr-2">
                <label for="end">End</label>
                <input type="date" class="form-control" v-model="end" id="end" placeholder="End">
            </div>
            <div class="d-flex align-items-center ml-5 custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="commented" v-model="commented">
                <label class="custom-control-label" for="commented">Most Commented</label>
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
            country: '',
            commented: false
        };
    },

    computed: {
        endpoint() {
            this.start
                ? this.start = moment(this.start).format('YYYY-MM-DD')
                : this.start = '';

            this.end
                ? this.end = moment(this.end).format('YYYY-MM-DD')
                : this.end = '';

            return this.commented
                ? `/event?title=${this.title}&description=${this.description}&country=${this.country}&start=${this.start}&end=${this.end}&commented=1`
                : `/event?title=${this.title}&description=${this.description}&country=${this.country}&start=${this.start}&end=${this.end}`;
        }
    },


    methods: {
        submitSearch() {
            axios.get(this.endpoint)
                .then(response => {
                    this.$emit('filtered', response.data);
                })
                .catch(error => {
                    alert('There was an error filtering events.');
                });
        }
    }
}
</script>

<style scoped>
    label{
        font-weight: 600;
    }
    .custom-control{
        font-weight: normal;
    }
    .dropdown-toggle{
        padding-left: 10px;
        border-radius: 0px !important;
    }
    .dropdown.dropdown-lg .dropdown-menu {
        padding: 15px;
    }
    .input-group .form-control{
        width: 100%;
        border-radius: 0.25rem !important;
    }
    .dropdown.dropdown-lg .dropdown-menu{
        min-width: 320px;
    }
    .dropdown-menu{
        box-shadow: 1px 4px 8px -1px #c1c1c1;
    }
</style>
