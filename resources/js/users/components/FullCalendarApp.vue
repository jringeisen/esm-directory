<template>
  <FullCalendar
    default-view="dayGridMonth" 
    :plugins="calendarPlugins"
    :selectable="true"
    @dateClick="selected"
  />
</template>

<script>

import FullCalendar from '@fullcalendar/vue'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'

export default {
  components: {
    FullCalendar
  },
  data() {
    return {
      calendarPlugins: [ dayGridPlugin, interactionPlugin ]
    }
  },
  methods: {
    selected (evt) {
      alert('You selected ' + evt.date)
    }
  }
}

</script>

<style lang='scss' scoped>

@import '~@fullcalendar/core/main.css';
@import '~@fullcalendar/daygrid/main.css';

</style>