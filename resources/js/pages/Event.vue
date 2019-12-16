<script>
import Favorite from "../components/Favorite";
import Comments from '../components/Comments.vue';
import SubscribeButton from '../components/SubscribeButton.vue';

export default {
    props: ['event'],

    components: { Comments, SubscribeButton, Favorite },

    data() {
        return {
            commentsCount: this.event.comments_count,
            locked: this.event.locked,
        };
    },

    methods: {
        lock() {
            this.locked = true;

            axios.post(`/locked-events/${this.event.id}`);
        },

        unlock() {
            this.locked = false;

            axios.delete(`/locked-events/${this.event.id}`);
        }
    }
}
</script>
