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
    props: ['endpoint'],

    data() {
        return {
            body: ''
        };
    },

    methods: {
        addComment() {
            axios.post(this.endpoint, { body: this.body })
                .then((data) => {
                    this.body = '';

                    flash('Your comment has been posted.');

                    this.$emit('created', data.data);
                });
        }
    }
}
</script>