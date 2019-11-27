<script>
import Favorite from "../components/Favorite";
import Comments from '../components/Comments.vue';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    props: ['initialCommentsCount'],

    components: { Comments, SubscribeButton, Favorite },

    data() {
        return {
            commentsCount: this.initialCommentsCount
        };
    }
}
</script>
