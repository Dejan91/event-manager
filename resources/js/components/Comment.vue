<script>
    import Favorite from './Favorite.vue';
import { log } from 'util';

    export default {
        props: ['attributes'],

        components: { Favorite },

        data() {
            return {
                editing: false,
                body: this.attributes.body
            };
        },

        methods: {
            update() {
                axios.patch('/comments/' + this.attributes.id, {
                    body: this.body
                });

                this.editing = false;

                flash('Comment updated.');
            },
            
            destroy() {
                axios.delete('/comments/' + this.attributes.id);

                $(this.$el).fadeOut(400);

                flash('Comment has been deleted.');
            }
        }
    }
</script>