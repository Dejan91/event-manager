<script>
import Comments from '../components/Comments.vue';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    props: ['initialCommentsCount'],

    components: { Comments, SubscribeButton },

    data() {
        return {
            commentsCount: this.initialCommentsCount
        };
    }
}
</script>