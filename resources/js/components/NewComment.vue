<template>
    <div class="mt-3">
        <div class="form-group">
            <textarea class="form-control"
                      name="body"
                      id="body"
                      rows="5"
                      placeholder="Have something to say?"
                      required
                      v-model="body"></textarea>
        </div>

        <button type="submit"
                class="btn btn-primary"
                @click="addComment">Post</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            body: '',
            currentEndpoint: this.endpoint + '/comments'
        };
    },

    methods: {
        addComment() {
            axios.post(location.pathname + '/comments', { body: this.body })
                .then((data) => {
                    this.body = '';

                    flash('Your comment has been posted.');

                    this.$emit('created', data.data);
                })
                .catch(error => {
                    flash(error.response.data, 'danger');
                });
        }
    }
}
</script>
