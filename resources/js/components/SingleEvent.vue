<template>
    <div class="card shadow-sm">
        <a id="eventImage" :href="'/event/'+event.id" @click="event.visitsCount ++" @mouseup.middle="event.visitsCount ++">
            <img :src="event.image_path" class="card-img-top" alt="event-image">
        </a>
        <div class="card-body">
            <div class="row">
                <div id="date" class="col-2">
                    <p id="month">{{ startDateMonth }}</p>
                    <p id="day">{{ startDateDayDigit }}</p>
                </div>
                <div id="title" class="col-10">
                    <h5 class="card-title">
                        <a :href="'/event/'+event.id" @click="event.visitsCount ++" @mouseup.middle="event.visitsCount ++">
                            {{ event.title.substring(0, 28)+"..." }}
                        </a>
                    </h5>
                    <p>{{ startDateDayLetter }} &centerdot; {{ country }}</p>
                    <p class="d-inline">{{ event.subscribersCount }} people interested</p>
                    <p class="d-inline ml-5">
                        <i class="far fa-eye"></i>
                        <span id="counter" v-text="event.visitsCount"></span>
                    </p>
                    <p class="d-inline float-right">
                        <favorite :model="data" instance="event" size="">
                        </favorite>
                    </p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import moment from 'moment';
    import Favorite from '../components/Favorite.vue';

    export default {
        props: ['data'],

        components: { Favorite },

        data() {
            return {
                event: this.data,
                country: this.data.country.name,
            }
        },

        computed: {
            startDateMonth() {
                return moment(this.event.start_date).format('MMM').toUpperCase();
            },

            startDateDayDigit() {
                return moment(this.event.start_date).format('DD');
            },

            startDateDayLetter() {
                return moment(this.event.start_date).format('dddd');
            },

            endDate() {
                return moment(this.event.end_date).format('MMM');
            }
        }
    }
</script>

<style scoped>
    .card {
        width: 48%;
        margin: 30px auto 0;
    }

    .card-body {
        padding: 10px 10px 10px 10px;
    }

    .fa-eye {
        color: #3490dc;
    }

    #counter {
        color: rgb(66, 66, 66);
    }

    #title {
        padding-left: 0;
    }

    #title h5 {
        margin: 0;
    }

    #title p {
        margin: 0;
        line-height: 18px;
        color: rgb(146, 146, 146);
    }

    #title a {
        text-decoration: none;
        color: black;
    }

    #title a:hover {
        text-decoration: underline;
    }

    #date {
        padding-right: 10px;
        text-align: center;
        line-height: 22px;
    }

    #date p {
        margin-bottom: 0;
    }

    #month {
        color: red;
    }

    #day {
        color: rgb(77, 77, 77);
        font-size: 20px;
        font-weight: 500;
    }

    #eventImage {
        background-color: black;
        transition: .3s ease-in-out;
        opacity: 0.8;
    }

    #eventImage:hover {
        opacity: 1;
    }

    @media (max-width: 1199px) {
        .card {
            width: 80%;
        }
    }

    @media (max-width: 991px) {
        .card {
            width: 96%;
        }
    }

    @media (max-width: 575px) {
        .card {
            width: 96%;
        }
        
        #title {
            padding: 0px 20px 20px 20px;
        }
    }
</style>
