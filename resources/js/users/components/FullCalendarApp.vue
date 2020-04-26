<template>
  <div>
    <FullCalendar
      default-view="dayGridMonth" 
      :plugins="calendarPlugins"
      :selectable="true"
      :events="events"
      @eventClick="eventClicked"
    />
    <create-booking-modal
      :photography-packages="photographyPackages"
      :event-details="eventDetails"
      :listing="listing"
    />
  </div>
</template>

<script>

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import CreateBookingModal from '../modals/bookings/CreateBookingModal.vue'
import ModalActions from '../../mixins/ModalActions.js'

export default {
  name: 'FullCalendarApp',
  props: {
    events: {
      type: Array,
      required: true,
      default: () => []
    },
    photographyPackages: {
      type: Array,
      required: true,
      default: () => []
    },
    listing: {
      type: Object,
      required: true,
      default: () => {}
    }
  },
  mixins: [
    ModalActions
  ],
  components: {
    FullCalendar,
    CreateBookingModal
  },
  data() {
    return {
      calendarPlugins: [ dayGridPlugin, interactionPlugin ],
      eventDetails: {}
    }
  },
  methods: {
    eventClicked (evt) {
      this.eventDetails = evt.event
      this.openModal('CreateBookingModal')
    }
  }
}

</script>

<style lang='scss'>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';

.fc-content {
  cursor: pointer !important;
}

</style>