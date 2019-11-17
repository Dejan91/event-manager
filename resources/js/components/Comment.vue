<script>
    export default {
        props: ['attributes'],

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

                // flash('Updated.');
            },
            
            destroy() {
                axios.delete('/comments/' + this.attributes.id);

                $(this.$el).fadeOut(400);

                // flash('Your reply has been deleted.');
            }
        }
    }
</script>