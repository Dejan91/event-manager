<template>
    <div>
        <v-md-date-range-picker @change="handleChange"></v-md-date-range-picker>
    </div>
</template>

<script>
import moment from 'moment';

export default {
    methods: {
        handleChange (values) {
            let start = moment(values[0]).format('DD-MM-YYYY');
            let end = moment(values[1]).format('DD-MM-YYYY');

            if (window.location.search === '') {
                window.location = `/event?start=${start}&end=${end}`;
            } else {
                window.location = window.location + `&start=${start}&end=${end}`;
            }
        }
    }
}
</script>
