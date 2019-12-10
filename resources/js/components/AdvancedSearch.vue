<template>
    <div class="col-xs-12 col-sm-offset-2 col-sm-8 mb-3">
        <div class="input-group" id="adv-search">
            <input @keydown.enter="searchByTitle" type="text" class="form-control" v-model="firstTitle" placeholder="Search by title" />
            <div class="input-group-btn">
                <div class="btn-group" role="group">
                    <div class="dropdown dropdown-lg">
                        <button  type="button" id="dlDropDown" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><span class=""></span></button>
                        <div class="dropdown-menu dropdown-menu-right" role="menu">
                            <form class="form-horizontal" role="form">
                                <div class="form-group mr-2">
                                    <label for="title">Title</label>
                                    <input type="text" class="form-control" v-model="title" id="title" placeholder="Title">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="description">Description</label>
                                    <input type="text" class="form-control" v-model="description" id="description" placeholder="Description">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="country">Country</label>
                                    <input type="text" class="form-control" v-model="country" id="country" placeholder="Country">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="start">Start</label>
                                    <input type="date" class="form-control" v-model="start" id="start" placeholder="Start">
                                </div>
                                <div class="form-group mr-2">
                                    <label for="end">End</label>
                                    <input type="date" class="form-control" v-model="end" id="end" placeholder="End">
                                </div>
                                <div class="custom-checkbox ml-4 mb-3">
                                    <input type="checkbox" class="custom-control-input" id="commented" v-model="commented">
                                    <label class="custom-control-label" for="commented">Most Commented</label>
                                </div>
                                <button @click.prevent="filter" type="submit" class="btn btn-primary"><span class="fas fa-search" aria-hidden="true"></span></button>
                            </form>
                        </div>
                    </div>
                    <button @click.prevent="searchByTitle" type="submit" class="btn btn-primary"><span class="fas fa-search" aria-hidden="true"></span></button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    data() {
        return {
            firstTitle: '',
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
            let params = {
              start: this.start,
              end: this.end,
              title: this.title,
              description: this.description,
              country: this.country,
              // commented: this.commented
            };

            let query =  Object.getOwnPropertyNames(params)
                    .map(key => (params[key] !== '') && key + '=' + params[key])
                    .filter(el => el !== false).join('&');

            return query
                    ? '?' + query
                    : query;

            // this.start
            //     ? this.start = moment(this.start).format('YYYY-MM-DD')
            //     : this.start = '';

            // this.end
            //     ? this.end = moment(this.end).format('YYYY-MM-DD')
            //     : this.end = '';

            // return this.commented
            //     ? `/event?title=${this.title}&description=${this.description}&country=${this.country}&start=${this.start}&end=${this.end}&commented=1`
            //     : `/event?title=${this.title}&description=${this.description}&country=${this.country}&start=${this.start}&end=${this.end}`;
        }
    },

    methods: {
        filter() {
            $("#dlDropDown").dropdown("toggle");

            axios.get(this.endpoint)
                .then(response => {
                    this.$emit('filtered', response.data);
                })
                .catch(error => {
                    alert('Sorry there was an error filtering events.');
                });
        },

        searchByTitle() {
            axios.get(`/event/search?q=${this.firstTitle}`)
                .then(response => {
                    this.$emit('filtered', response.data);
                })
                .catch(error => {
                    alert('Sorry there was an error while searching.');
                });
        }
    }
}
</script>

<style scoped>
    body {
        padding-top: 50px;
    }
    .dropdown.dropdown-lg .dropdown-menu {
        margin-top: -1px;
        padding: 6px 20px;
    }
    .input-group-btn .btn-group {
        display: flex !important;
    }
    .btn-group .btn {
        border-radius: 0;
        margin-left: -1px;
    }
    .btn-group .btn:last-child {
        border-top-right-radius: 4px;
        border-bottom-right-radius: 4px;
    }
    .btn-group .form-horizontal .btn[type="submit"] {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }
    .form-horizontal .form-group {
        margin-left: 0;
        margin-right: 0;
    }
    .form-group .form-control:last-child {
        border-top-left-radius: 4px;
        border-bottom-left-radius: 4px;
    }

    @media screen and (min-width: 768px) {
        #adv-search {
            width: 730px;
            margin: 0 auto;
        }
        .dropdown.dropdown-lg {
            position: static !important;
        }
        .dropdown.dropdown-lg .dropdown-menu {
            min-width: 730px;
        }
    }
</style>
