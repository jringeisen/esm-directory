<template>
  <b-modal
    :id="$options.name"
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
import flatPickr from 'vue-flatpickr-component';
import 'flatpickr/dist/flatpickr.css';
export default {
  name: 'EditBookingModal',
  mixins: [
    ModalActions
  ],
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
    submit (evt) {
      evt.preventDefault()

      // Accepts two params: URL, name for $emit event.
      this.updateItem('/api/bookings/', 'getUser')
    }
  }
}
</script>
