<template>
    <div class="mt-3 mb-3">
        <div class="form-group">
            <textarea class="form-control"
                      name="body"
                      id="body"
                      rows="2"
                      placeholder="Post your comment here"
                      required
                      v-model="body">
            </textarea>
        </div>

        <button type="submit"
                class="btn btn-primary"
                @click="addComment">Post
        </button>
    </div>
</template>

<script>
import 'jquery.caret';
import 'at.js';

export default {
    data() {
        return {
            body: '',
            currentEndpoint: this.endpoint + '/comments'
        };
    },

    mounted() {
        $('#body').atwho({
            at: '@',
            delay: 750,
            callbacks: {
                remoteFilter: function (query, callback) {
                    $.getJSON("/api/users", {name: query}, function(usernames) {
                       callback(usernames);
                    });
                }
            }
        });
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
                    if (this.verificationEmailError(error)) {
                        emailVerificationModal();
                    } else {
                        flash(error.response.data.message, 'danger');
                    }
                });
        },

        verificationEmailError(error) {
            if (error.response.data.message === "Your email address is not verified.") {
                return true;
            }
            return false;
        }
    }
}
</script>
