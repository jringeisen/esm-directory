<template>
  <b-modal
    :id="$options.name"
    title="Delete Listing"
  >
    <div class="alert alert-danger">
      Are you sure you want to delete this listing?
    </div>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="closeModal($options.name)"
      >
        Cancel
      </button>
      <button
        class="btn btn-secondary"
        :disabled="isLoading"
        @click.prevent="submit"
      >
        <b-spinner
          v-if="isLoading"
          small
          type="grow"
        />
        {{ isLoading ? 'Loading...' : 'Submit' }}
      </button>
    </div>
  </b-modal>
</template>

<script>
import ToastMixin from '../../../mixins/ToastMixin.js'
import ModalActions from '../../../mixins/ModalActions.js'
export default {
  name: 'DeleteListingModal',
  mixins: [ToastMixin, ModalActions],
  props: {
    listing: {
      required: true,
      type: Object
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
      axios.delete(`/api/listings/${this.listing.id}`).then((response) => {
        this.$root.$emit('updateUser')
        this.isLoading = false
        this.closeModal(this.$options.name)
        this.toast('success', 'Success!', 'Your listing was deleted successfully!')
      })
    }
  }
}
</script>

