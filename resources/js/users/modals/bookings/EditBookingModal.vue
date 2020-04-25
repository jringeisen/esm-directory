<template>
  <b-modal
    :id="'edit-booking-modal'"
    title="Edit Booking"
    @shown="shown"
    @ok="submit"
  >
    <div class="form-group">
      <label for="name">Name</label>
      <input
        v-model="formData.name"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input
        v-model="formData.email"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="package">Package</label>
      <input
        v-model="formData.package"
        type="text"
        class="form-control"
      > 
    </div>
    <div class="form-group">
      <label for="requested_date">Requested Date</label>
      <flat-pickr
        class="form-control"
        :config="calendarConfig"
        v-model="formData.requested_date"
      />
    </div>
    <div class="form-group">
      <label for="message">Message</label>
      <textarea
        v-model="formData.message"
        class="form-control"
        placeholder="Enter your message here."
      />
    </div>
    <div class="form-group form-check">
      <input
        type="checkbox"
        class="form-check-input"
        v-model="formData.confirmed_on"
        id="confirmBookingRequest"
      >
      <label
        class="form-check-label"
        for="confirmBookingRequest"
      >Confirm Booking Request</label>
    </div>
    <div
      class="form-group form-check"
      v-if="formData.confirmed_on"
    >
      <input
        type="checkbox"
        class="form-check-input"
        v-model="formData.send_confirmation"
        id="confirmBookingRequest"
      >
      <label
        class="form-check-label"
        for="confirmBookingRequest"
      >Send Confirmation Email</label>
    </div>
    <div slot="modal-footer">
      <button
        class="btn btn-outline-secondary"
        @click.prevent="hideModal(booking.id)"
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
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
export default {
  mixins: [ToastMixin],
  props: {
    booking: {
      required: true,
      type: Object
    }
  },
  components: {
    flatPickr
  },
  data () {
    return {
      formData: {},
      isLoading: false,
      calendarConfig: {
        altFormat: 'F j, Y h:i:S K',
        altInput: true,
        enableTime: true
      }
    }
  },
  methods: {
    shown () {
      this.formData = this.booking
    },
    submit () {
      this.isLoading = true
      axios.put(`/api/bookings/${this.booking.id}`, this.formData).then((response) => {
        this.isLoading = false
        this.hideModal()
        this.toast('success', 'Success!', 'Your booking was deleted successfully!')
      }).catch((error) => {
        this.isLoading = false
        this.toast('danger', 'Something went wrong!', 'Whoops.. Looks like something went wrong.')
      })
    },
    hideModal (id) {
      this.$root.$emit('bv::hide::modal', 'edit-booking-modal')
    }
  }
}
</script>
