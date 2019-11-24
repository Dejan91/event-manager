<template>
    <div class="modal fade" id="verificationEmailModal" tabindex="-1" role="dialog" aria-labelledby="verificationEmailModal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Verify Your Email Address</h5>
                </div>
                <div class="modal-body">
                    <p>Before proceeding, please check your email for a verification link</p>
                    <p>If you did not receive the email</p>
                    <button @click="resendVerificationEmail" type="submit" id="resendVerification" class="btn btn-link p-0 m-0 align-baseline">Click here to request another</button>.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            show: false
        }
    },

    created() {
        window.events.$on('emailVerification', () =>  this.showModal() );
    },

    methods: {
        showModal() {
            $("#verificationEmailModal").modal("show");
        },

        hideModal() {
            $("#verificationEmailModal").modal("hide");
        },

        resendVerificationEmail() {
            this.hideModal();

            axios.post('/email/resend')
                .then(response => {
                    flash('Verification email resent.');
                })
                .catch(error => {
                    alert('There was an error resending your verification email.');
                });
        }
    }
}
</script>