<template>
  <div class="card shadow">
    <div class="card-header">
      <div style="display: flex; justify-content: space-between; align-items: center;">
        <span>Booking Requests</span>
      </div>
    </div>
    <div class="card-body">
      <div
        v-if="!bookings.length"
        class="text-center"
      >
        <h5 class="card-title">
          You haven't received any booking requests yet.
        </h5>
        <p class="card-text">
          Your booking requests will be displayed here when a client picks a date from your calendar and submits a request.
        </p>
      </div>
      <div class="table-responsive">
        <table
          v-if="bookings.length"
          class="table table-hover"
        >
          <thead>
            <tr>
              <th>Status</th>
              <th>Name</th>
              <th>Email</th>
              <th>Package</th>
              <th>Date Requested</th>
              <th>Message</th>
              <th>&nbsp;</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="(booking, index) in bookings"
              :key="index"
            >
              <td class="align-middle">
                <span
                  class="badge"
                  :class="{'badge-success': booking.confirmed_on, 'badge-danger': !booking.confirmed_on}"
                >{{ booking.confirmed_on ? 'Confirmed' : 'Not Confirmed' }}</span>
              </td>
              <td class="align-middle">
                {{ booking.name }}
              </td>
              <td class="align-middle">
                {{ booking.email }}
              </td>
              <td class="align-middle">
                {{ booking.package }}
              </td>
              <td class="align-middle">
                {{ booking.requested_date | moment('LLL') }}
              </td>
              <td class="align-middle">
                {{ booking.message }}
              </td>
              <td class="text-right align-middle">
                <b-dropdown
                  id="dropdown-1"
                  no-caret
                  dropright
                  variant="white"
                  class="m-md-2"
                >
                  <template #button-content>
                    <i class="fas fa-ellipsis-v" />
                  </template>
                  <b-dropdown-item>
                    Edit Booking
                  </b-dropdown-item>
                  <b-dropdown-item>
                    Delete Booking
                  </b-dropdown-item>
                </b-dropdown>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import ToastMixin from '../../mixins/ToastMixin.js'
export default {
  mixins: [ToastMixin],
  data() {
    return {
      bookings: []
    }
  },
  mounted () {
    this.getBookings()
  },
  methods: {
    getBookings () {
      axios.get('/bookings').then((response) => {
        this.bookings = response.data
      }).catch((error) => {
        this.toast('danger', 'Something went wrong!', 'It looks like something went wrong when trying to retrieve your booking requests.')
      })
    }
  }
}
</script>
