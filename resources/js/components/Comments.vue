<template>
    <div>
        <div class="alert alert-warning mt-2" role="alert" v-if="$parent.locked">
            This event has been locked by admin and may not be commented anymore.
        </div>

        <new-comment @created="add" v-else></new-comment>

        <comment
            v-for="(comment, index) in items"
            :key="comment.id"
            :data="comment"
            @deleted="remove(index)">
        </comment>

        <paginator :dataSet="dataSet" @changed="fetch"></paginator>
    </div>
</template>

<script>
import Comment from './Comment.vue';
import NewComment from './NewComment.vue';

export default {
    components: { Comment, NewComment },

    data() {
        return {
            dataSet: false,
            items: []
        }
    },

    created() {
        this.fetch();
    },

    methods: {
        fetch(page) {
            axios.get(this.url(page))
                .then(this.refresh);
        },

        url(page = 1) {
            if (! page) {
                let query = location.search.match(/page=(\d+)/);

                page = query ? query[1] : 1;
            }

            return location.pathname + '/comments?page=' + page;
        },

        refresh({data}) {
            this.dataSet = data;
            this.items = data.data;

            window.scrollTo(0, 0);
        },

        add(item) {
            this.items.unshift(item);

            this.$emit('added');
        },

        remove(index) {
            this.items.splice(index, 1);

            this.$emit('removed');
        }
    }
}
</script>
