<template>
<nav aria-label="Page navigation example" class="mt-2">
    <ul class="pagination" v-if="shouldPaginate">
        <li class="page-item" v-show="prevUrl">
            <a href="#" aria-label="Previous" class="page-link" @click.prevent="page--">
                Previous
            </a>
        </li>
        <li class="page-item" v-show="nextUrl">
            <a href="#" aria-label="Next" class="page-link" @click.prevent="page++">
                Next
            </a>
        </li>
    </ul>
</nav>
</template>

<script>
export default {
    props: ['dataSet'],

    data() {
        return {
            page: 1,
            prevUrl: false,
            nextUrl: false,
        }
    },

    watch: {
        dataSet() {
            this.page = this.dataSet.current_page;
            this.prevUrl = this.dataSet.prev_page_url;
            this.nextUrl = this.dataSet.next_page_url;
        },

        page() {
            this.broadcast().updateUrl();
        }
    },

    computed: {
        shouldPaginate() {
            return !! this.prevUrl || !! this.nextUrl;
        }
    },

    methods: {
        broadcast() {
            return this.$emit('changed', this.page);
        },

        updateUrl() {
            history.pushState(null, null, '?page=' + this.page);
        }
    }
}
</script>