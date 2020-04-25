<template>
  <b-modal
    :id="$options.name"
    title="Delete Booking"
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
import ToastMixin from '../../../mixins/ToastMixin.js'
import ModalActions from '../../../mixins/ModalActions.js'
export default {
  name: 'DeleteBookingModal',
  mixins: [ToastMixin, ModalActions],
  props: {
    booking: {
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
      axios.delete(`/api/bookings/${this.booking.id}`).then((response) => {
        this.$root.$emit('updateUser')
        this.isLoading = false
        this.closeModal(this.booking.id)
        this.toast('success', 'Success!', 'Your booking was deleted successfully!')
      })
    }
  }
}
</script>

