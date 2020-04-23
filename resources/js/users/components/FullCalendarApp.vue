<template>
  <FullCalendar
    default-view="dayGridMonth" 
    :plugins="calendarPlugins"
    :selectable="true"
    :events="events"
    @dateClick="dateClicked"
    @eventClick="eventClicked"
  />
</template>

<script>

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  props: {
    events: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  components: {
    FullCalendar
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
      alert('You are booking an event for ' + evt.event.start + ' to ' + evt.event.end)
    }
  }
}

</script>

<style lang='scss' scoped>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';

</style>