<template>
    <div :id="id" class="card mt-3">
        <div class="card-header">
            <div class="level">
                <h5 class="flex">
                    <img v-bind:src="data.owner.thumb_path" width="50px" height="50px">
                    <a href="#" class="ml-2" v-text="data.owner.name"></a>
                </h5>
                <div>
                    <favorite :model="data" instance="comment"></favorite>
                </div>
            </div>
        </div>

        <div class="card-body">

            <div class="row">
                <div class="col-md-12" v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <button class="btn btn-sm btn-primary float-right" @click="update">Update</button>
                    <button class="btn btn-sm btn-link float-right" @click="editing = false">Cancel</button>
                </div>

                <div v-else>
                    <div class="col-md-12 mb-1 text-secondary">
                        <span class="fas fa-clock mr-2"></span><span v-text="ago"></span>
                    </div>
                    <div class="col-md-12" v-text="body"></div>
                </div>
            </div>
            <div class="row mt-3" v-if="canUpdate">
                <div class="ml-auto">
                    <button class="btn btn-secondary btn-sm " @click="editing = true">Edit</button>
                    <button class="btn btn-sm btn-danger ml-1 mr-3" @click="destroy">Delete</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Favorite from './Favorite.vue';
import moment from 'moment';

export default {
    props: ['data'],

    components: { Favorite },

    data() {
        return {
            editing: false,
            body: this.data.body
        };
    },

    computed: {
        id() {
            return `comment-${this.data.id}`;
        },

        canUpdate() {
            return this.authorize(user => this.data.user_id == user.id);
        },

        ago() {
            return moment(this.data.created_at).fromNow();
        }
    },

    methods: {
        update() {
            axios.patch('/comments/' + this.data.id, {
                body: this.body
            })
            .then(response => {
                this.editing = false;

                flash('Comment updated.');
            })
            .catch(error => {
                if (this.verificationEmailError(error)) {
                    emailVerificationModal();
                }
            });
        },

        destroy() {
            axios.delete('/comments/' + this.data.id)
                .then(response => {
                    this.$emit('deleted', this.data.id);
                    flash('Comment deleted');
                })
                .catch(error => {
                    if (this.verificationEmailError(error)) {
                        emailVerificationModal();
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
