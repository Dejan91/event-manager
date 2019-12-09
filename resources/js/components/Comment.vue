<template>
    <div class="card mb-3">
        <div class="row no-gutters">
            <div class="col-sm-1">
                <a :href="ownerPath">
                    <img v-bind:src="data.owner.thumb_path" class="mt-3" id="userAvatar" width="50px" height="50px">
                </a>
            </div>
            <div class="col-sm-10">
                <div class="card-body nopadding" v-if="editing">
                    <div class="form-group">
                        <textarea class="form-control" v-model="body"></textarea>
                    </div>
                    <a class="d-inline anchor" id="cancel" @click="editing = false">Cancel</a>
                    <a class="d-inline ml-2 anchor" id="update" @click="update">Update</a>
                </div>
                <div class="card-body nopadding" v-else>
                    <a :href="ownerPath" id="owner">
                        <h6 class="card-title d-inline">
                            <strong v-text="data.owner.name"></strong>
                        </h6>
                    </a>
                    <small class="text-muted d-inline ml-2" v-text="ago"></small>
                    <p class="card-text mt-1" v-text="body"></p>
                    <div class="ml-auto" v-if="canUpdate">
                        <a class="d-inline anchor" @click="editing = true">Edit</a>
                        <a class="d-inline ml-2 anchor" id="delete" @click="destroy">Delete</a>
                    </div>
                </div>
            </div>
            <div class="col-sm-1">
                <favorite :model="data" instance="comment"></favorite>
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
        },

        ownerPath() {
            return `/users/${this.data.owner.id}/profile`;
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
                } else {
                    flash(error.response.data, 'danger');
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

<style scoped>
    .card {
        border: none;
        background-color: #f8fafc;
    }

    .anchor:hover {
        cursor: pointer;
        text-decoration: underline !important;
    }

    .nopadding {
        padding-left: 0;
    }

    #delete {
        color: red;
    }

    #cancel {
        color: blue;
    }

    #update {
        color: rgb(199, 153, 3);
    }

    #userAvatar {
        border-radius: 50%;
    }

    #owner {
        text-decoration: none;
        color: black;
    }

    #owner:hover {
        cursor: pointer;
    }
</style>
