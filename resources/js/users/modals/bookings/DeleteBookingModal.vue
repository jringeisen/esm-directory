<template>
  <b-modal
    :id="$options.name"
    title="Delete Booking"
    @shown="shown"
  >
    <div class="alert alert-danger">
      Are you sure you want to delete this booking?
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
import ModalActions from '../../../mixins/ModalActions.js'
export default {
  name: 'DeleteBookingModal',
  mixins: [
    ModalActions
  ],
  props: {
    booking: {
      required: true,
      type: Object
    }
  },
  methods: {
    shown () {
      this.formData = this.booking
    },
    submit (evt) {
      evt.preventDefault()
      
      // Accepts two params: URL, name for $emit event.
      this.deleteItem('/api/bookings/', 'getUser')
    }
  }
}
</script>

