<template>
    <b-modal :id="'delete-'+listing.id" :ref="'delete-'+listing.id+'-modal'" title="Delete Listing">
        <div class="alert alert-danger">Are you sure you want to delete this listing?</div>
        <div slot="modal-footer">
            <button class="btn btn-outline-secondary" @click.prevent="hideModal(listing.id)">Cancel</button>
            <button class="btn btn-secondary" :disabled="isLoading" @click.prevent="submit">
                <b-spinner v-if="isLoading" small type="grow"></b-spinner>
                {{ isLoading ? 'Loading...' : 'Submit'}}
            </button>
        </div>
    </b-modal>
</template>

<script>
import ToastMixin from '../../mixins/ToastMixin.js'
export default {
    mixins: [ToastMixin],
    props: {
        listing: {
            required: true
        }
    },
    data () {
        return {
            isLoading: false
        }
    },
    methods: {
        submit () {
            this.isLoading = true
            axios.delete(`/listings/${this.listing.id}`).then((response) => {
                this.$root.$emit('updateUser')
                this.isLoading = false
                this.hideModal()
                this.toast('success', 'Success!', 'Your listing was deleted successfully!')
            })
        },
        hideModal (id) {
            this.$refs['delete-'+id+'-modal' ].hide()
        }
    }
}
</script>

