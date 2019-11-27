<template>
    <li>
        <time datetime="2014-07-31 1600">
            <span class="day">{{ startDate }}</span>
<!--            <span class="month">{{ $event->start_date->format('M') }}</span>-->
        </time>

        <div class="info">
            <h2 class="title" v-text="event.title"></h2>
        </div>
<!--        <time datetime="2014-07-31 1600">-->
<!--            <span class="day">{{ $event->start_date->format('d') }}</span>-->
<!--            <span class="month">{{ $event->start_date->format('M') }}</span>-->
<!--        </time>-->

<!--        <img alt="My 24th Birthday!" src="{{ $event->image_path }}" />-->
<!--        <div class="info">-->
<!--            <h2 class="title">{{ Str::limit($event->title, 30, '...') }}</h2>-->
<!--            <p class="desc">{{ Str::limit($event->description, 100, '...') }}</p>-->
<!--            <ul>-->
<!--                <li style="width:33%;">{{ $event->subscribersCount }}  <span class="fa fa-male"></span></li>-->
<!--                <li style="width:34%;"><a href="{{ $event->path() }}">Show More  <span class="fa fa-info-circle"></span></a></li>-->
<!--            </ul>-->
<!--        </div>-->
<!--        <div class="social">-->
<!--            <ul>-->
<!--                <li id="favoriteEvent" class="facebook" style="width:33%;"><a href="#"><span class="fa fa-heart">{{ $event->favorites_count }}</span></a></li>-->
<!--                <li class="twitter" style="width:34%;"><a href="#"><span class="fa fa-comment">{{ $event->comments_count }}</span></a></li>-->
<!--            </ul>-->
<!--        </div>-->
    </li>
</template>

<script>
    import moment from 'moment';

    export default {
        props: ['data'],

        data() {
            return {
                event: this.data
            }
        },

        computed: {
            startDate() {
                return moment(this.event.start_date).format('DD');
            }
        }
    }
</script>
