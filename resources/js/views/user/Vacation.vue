<template>
  <v-container>
    <v-row>
      <v-col>
        <add-vacation/>
      </v-col>
      <v-col></v-col>
      <v-col></v-col>
    </v-row>
    <v-row class="fill-height">
      <v-col>
        <v-sheet height="600">
          <v-calendar
            ref="calendar"
            v-model="focus"
            color="primary"
            :type="type"
            :events="events"
            :names="names"
            :colors="colors"
            @change="updateRange"
          ></v-calendar>
        </v-sheet>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Libs
   */
  import moment from 'moment';

  /**
   * Components
   */
  import AddVacation from '../../components/vacation/AddVacation';

  /**
   * Управление отпуском
   */
  export default {
    name: 'Vacation',
    components: {
      AddVacation
    },
    data() {
      return {
        focus: '',
        type: 'month',
        events: [],
        colors: ['success'],
        names: ['Отпуск']
      };
    },
    computed: {
      user() {
        return this.$store.getters.getUser;
      },
    },
    mounted() {
      // this.$refs.calendar.checkChange()
    },
    methods: {
      viewDay({date}) {
        this.focus = date
        this.type = 'day'
      },
      getEventColor(event) {
        return event.color
      },
      setToday() {
        this.focus = ''
      },
      prev() {
        this.$refs.calendar.prev()
      },
      next() {
        this.$refs.calendar.next()
      },
      showEvent({nativeEvent, event}) {
        const open = () => {
          this.selectedEvent = event
          this.selectedElement = nativeEvent.target
          setTimeout(() => this.selectedOpen = true, 10)
        }

        if (this.selectedOpen) {
          this.selectedOpen = false
          setTimeout(open, 10)
        } else {
          open()
        }

        nativeEvent.stopPropagation()
      },
      updateRange({start, end}) {
        const events = []

        const min = new Date(`${start.date}T00:00:00`)
        const max = new Date(`${end.date}T23:59:59`)
        // const days = (max.getTime() - min.getTime()) / 86400000
        // const eventCount = this.rnd(days, days + 20)

        // for (let i = 0; i < eventCount; i++) {
        //   const allDay = this.rnd(0, 3) === 0
        const firstTimestamp = this.rnd(min.getTime(), max.getTime())
        const first = new Date(firstTimestamp - (firstTimestamp % 900000))
        // const secondTimestamp = this.rnd(2, allDay ? 288 : 8) * 900000
        // const second = new Date(first.getTime() + secondTimestamp)

        events.push({
          name: 'Отпуск',
          start: new Date(),
          end: moment().add(3, 'days').valueOf(),
          color: this.colors[this.rnd(0, this.colors.length - 1)],
          // timed: 10,
        })

        events.push({
          name: 'Отпуск',
          start: moment().add(5, 'days').valueOf(),
          end: moment().add(7, 'days').valueOf(),
          color: this.colors[this.rnd(0, this.colors.length - 1)],
          // timed: 10,
        })
        // }

        this.events = events
      },
      rnd(a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
  }

</script>
