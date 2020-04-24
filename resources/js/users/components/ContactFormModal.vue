<template>
  <b-modal
    id="request-booking"
    title="Request A Booking"
    @ok="submit"
  >
    <div class="row justify-content-center">
      <div class="col-12">
        <form>
          <div class="form-group">
            <label>Name</label>
            <input
              type="text"
              class="form-control"
              :class="{ 'is-invalid': formErrors.name }"
              placeholder="Enter your full name..."
              @keyup="formErrors.name = ''"
              v-model="formData.name"
            >
            <div
              v-if="formErrors.name"
              class="invalid-feedback"
            >
              {{ formErrors.name[0] }}
            </div>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input
              type="email"
              class="form-control"
              :class="{ 'is-invalid': formErrors.email }"
              placeholder="Enter your email address..."
              @keyup="formErrors.email = ''"
              v-model="formData.email"
            >
            <div
              v-if="formErrors.email"
              class="invalid-feedback"
            >
              {{ formErrors.email[0] }}
            </div>
          </div>
          <div class="form-group">
            <label>Choose a package</label>
            <select 
              class="form-control"
              :class="{ 'is-invalid': formErrors.package }"
              @change="formErrors.package = ''"
              v-model="formData.package"
            >
              <option value="">
                Choose a package:
              </option>
              <option
                v-for="(item, index) in photographyPackages"
                :key="index"
                :value="item.name"
              >
                {{ item.name + ' - ' + item.amount }}
              </option>
            </select>
            <small
              id="passwordHelpBlock"
              class="form-text text-muted"
            >
              For more details on each package, visit the package tab.
            </small>
            <div
              v-if="formErrors.package"
              class="invalid-feedback"
            >
              {{ formErrors.package[0] }}
            </div>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea
              class="form-control"
              :class="{ 'is-invalid': formErrors.message }"
              rows="4"
              placeholder="Enter your message..."
              @keyup="formErrors.message = ''"
              v-model="formData.message"
            />
            <div
              v-if="formErrors.message"
              class="invalid-feedback"
            >
              {{ formErrors.message[0] }}
            </div>
          </div>
          <div class="alert alert-info">
            You are requesting to book a session on <a class="alert-link">{{ eventDetails.start | moment('LLLL') }}</a>. I will get back with you shortly to confirm your appointment.
          </div>
        </form>
      </div>
    </div>
  </b-modal>
</template>

<script>
export default {
  props: {
    photographyPackages: {
      type: Array,
      required: true,
      default: () => []
    },
    eventDetails: {
      type: Object,
      required: true,
      default: () => {}
    },
    listing: {
      type: Object,
      required: true,
      default: () => {}
    }
  },
  data() {
    return {
      formData: {
        package: ''
      },
      formErrors: []
    }
  },
  methods: {
    submit (bvt) {
      bvt.preventDefault()

      this.formData.user_id = this.listing.user_id
      this.formData.requested_date = this.$moment(this.eventDetails.start).format()

      axios.post('/api/bookings', this.formData).then(() => {
        console.log('success')
      }).catch((error) => {
        this.formErrors = error.response.data.errors
      })
    }
  }
        
}
</script>