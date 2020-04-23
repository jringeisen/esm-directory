<template>
  <div>
    <FullCalendar
      default-view="dayGridMonth" 
      :plugins="calendarPlugins"
      :selectable="true"
      :events="events"
      @dateClick="dateClicked"
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
    dateClicked (evt) {
      alert('You selected ' + evt.date)
    },
    eventClicked (evt) {
      this.$root.$emit('bv::show::modal', 'request-booking')
    }
  }
}

</script>

<style lang='scss' scoped>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';

</style>