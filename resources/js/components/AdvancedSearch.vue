<template>
    <form class="mt-3 mb-3 ml-2" action="" method="GET">
        <div class="row">
            <div class="form-group mr-2">
                <label for="start">Start</label>
                <input type="date" class="form-control" v-model="start" id="start" placeholder="Start">
            </div>
            <div class="form-group mr-2">
                <label for="end">End</label>
                <input type="date" class="form-control" v-model="end" id="end" placeholder="End">
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" v-model="commented" id="commented">
                <label class="form-check-label" for="commented">
                    Most Commented
                </label>
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

<!-- <div class="row">
<div class="col-lg-6 offset-lg-3 col-sm-8 offset-sm-2 col-12">
    <h3 class="text-center text-light">Advance search with bootstrap 4</h3>
    <div class="input-group" id="adv-search">
    <input type="text" class="form-control form-control-search" placeholder="Search for snippets" />
    <div class="input-group-btn">
        <div class="btn-group" role="group">
        <div class="dropdown dropdown-lg">
            <button type="button" class="btn btn-lg btn-secondary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            </button>  
            <div class="dropdown-menu dropdown-menu-right" role="menu">
            <form>
                <div class="form-group">
                <label for="category" class="text-dark">Category</label>
                <select class="form-control" id="category">
                    <option>All Snippets</option>
                    <option>Featured</option>
                    <option>Most Popular</option>
                    <option>Most Commented</option>
                    <option>Most Liked</option>
                </select>
                </div>
                <div class="form-group">
                <label for="designer">Designer</label>
                <input type="text" class="form-control" id="designer" placeholder="Enter designer name">
                </div>
                <div class="form-group">
                <label for="contain_word">Contains Words</label>
                <input type="text" class="form-control" id="contain_word" placeholder="Enter contain words">
                </div>
                <div class="form-group">
                <label>Color</label><br>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Red</span>
                </label>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Blue</span>
                </label>
                <label class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">All</span>
                </label>
                </div>
                <div class="form-group">
                <label>Custom JS</label><br>
                <label class="custom-control custom-radio">
                    <input id="radio1" name="radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">Yes</span>
                </label>
                <label class="custom-control custom-radio">
                    <input id="radio2" name="radio" type="radio" class="custom-control-input">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">No</span>
                </label>
                </div>
                <hr>
                <div class="form-group text-center">
                <button type="submit" class="btn btn-primary">Search</button>
                </div>
            </form>                            
            </div>
        </div>
        <button type="submit" class="btn btn-primary"><span class="fa fa-search" aria-hidden="true"></span></button>
        </div>
    </div>
    </div>
</div>
</div> -->
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
                ? this.start = moment(this.start).format('DD-MM-YYYY')
                : this.start = '';

            this.end
                ? this.end = moment(this.end).format('DD-MM-YYYY')
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