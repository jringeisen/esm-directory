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
              v-for="(item, index) in bookings"
              :key="index"
            >
              <td class="align-middle">
                <span
                  class="badge"
                  :class="{'badge-success': item.confirmed_on, 'badge-danger': !item.confirmed_on}"
                >{{ item.confirmed_on ? 'Confirmed' : 'Not Confirmed' }}</span>
              </td>
              <td class="align-middle">
                {{ item.name }}
              </td>
              <td class="align-middle">
                {{ item.email }}
              </td>
              <td class="align-middle">
                {{ item.package }}
              </td>
              <td class="align-middle">
                {{ item.requested_date | moment('LLL') }}
              </td>
              <td class="align-middle">
                {{ item.message }}
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
                  <b-dropdown-item
                    @click.prevent="openEditModal(item)"
                  >
                    Edit Booking
                  </b-dropdown-item>
                  <b-dropdown-item
                    @click.prevent="openDeleteModal(item)"
                  >
                    Delete Booking
                  </b-dropdown-item>
                </b-dropdown>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <edit-booking-modal :booking="booking" />
    <delete-booking-modal :booking="booking" />
  </div>
</template>

<script>
import EditBookingModal from '../modals/bookings/EditBookingModal.vue'
import DeleteBookingModal from '../modals/bookings/DeleteBookingModal.vue'
import ToastMixin from '../../mixins/ToastMixin.js'
export default {
  mixins: [ToastMixin],
  components: {
    EditBookingModal,
    DeleteBookingModal
  },
  data() {
    return {
      bookings: [],
      booking: {}
    }
  },
  mounted () {
    this.$root.$on('updateUser', () => this.getBookings())
    this.getBookings()
  },
  methods: {
    getBookings () {
      axios.get('/api/user').then((response) => {
        this.bookings = response.data.bookings
      }).catch((error) => {
        this.toast('danger', 'Something went wrong!', 'It looks like something went wrong when trying to retrieve your booking requests.')
      })
    },
    openEditModal (data) {
      this.booking = data
      this.$root.$emit('bv::show::modal', 'edit-booking-modal')
    },
    openDeleteModal (data) {
      this.booking = data
      this.$root.$emit('bv::show::modal', 'delete-booking-modal')
    }
  }
}
</script>
