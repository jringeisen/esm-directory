<template>
  <div>
    <FullCalendar
      default-view="dayGridMonth" 
      :plugins="calendarPlugins"
      :selectable="true"
      :events="events"
      @eventClick="eventClicked"
    />
    <contact-form-modal :photography-packages="photographyPackages" />
  </div>
</template>

<script>

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import ContactFormModal from '../components/ContactFormModal.vue'

export default {
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
    }
  },
  components: {
    FullCalendar,
    ContactFormModal
  },
  data() {
    return {
      calendarPlugins: [ dayGridPlugin, interactionPlugin ]
    }
  },
  methods: {
    eventClicked (evt) {
      this.$root.$emit('bv::show::modal', 'request-booking')
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