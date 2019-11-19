<template>
    <div>
        <div v-for="(comment, index) in items" v-bind:key="comment.id">
            <comment :data="comment" @deleted="remove(index)"></comment>
        </div>

        <new-comment :endpoint="endpoint" @created="add"></new-comment>
    </div>
</template>

<script>
import Comment from './Comment.vue';
import NewComment from './NewComment.vue';

export default {
    props: ['data'],

    components: { Comment, NewComment },

    data() {
        return {
            items: this.data,
            endpoint: location.pathname.split("/")[2] + '/comments'
        }
    },

    methods: {
        add(comment) {
            this.items.push(comment);

            this.$emit('added');
        },

        remove(index) {
            this.items.splice(index, 1);

            this.$emit('removed');

            flash('Comment was deleted.');
        }
    }
}
</script>