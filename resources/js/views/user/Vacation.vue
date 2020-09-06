<template>
  <v-container>
    <v-row>
      <v-col>
        <add-vacation
          :loading="loading"
          @input="addedVacation"
        />
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
            :event-color="getEventColor"
            @click:event="showEvent"
          ></v-calendar>
          <v-menu
            v-model="selected_open"
            :close-on-content-click="false"
            :activator="selected_element"
            offset-x
          >
            <v-card
              color="grey lighten-4"
              min-width="350px"
              flat
            >
              <v-toolbar
                :color="selected_event.color"
                dark
              >
                <v-toolbar-title v-html="selected_event.name"/>
              </v-toolbar>
              <v-card-text>
                <edit-vacation
                  v-if="selected_event.details && !selected_event.details.vacation.readonly"
                  :vacation="selected_event.details.vacation"
                  @input="editedVacation"
                />
              </v-card-text>
              <v-card-actions>
                <v-btn
                  text
                  color="secondary"
                  @click="selected_open = false"
                >
                  Отмена
                </v-btn>
              </v-card-actions>
            </v-card>
          </v-menu>
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
  import axios from 'axios';

  /**
   * Components
   */
  import AddVacation from '../../components/vacation/AddVacation';
  import EditVacation from '../../components/vacation/EditVacation';

  /**
   * Управление отпуском
   */
  export default {
    name: 'Vacation',
    components: {
      AddVacation,
      EditVacation,
    },
    data() {
      return {
        focus: '',
        type: 'month',
        events: [],
        event_color: {
          waiting: 'amber accent-4',
          approved: 'green'
        },
        event_name_approved: 'Удачного отпуска',
        event_name_waiting: 'Заявка на отпуск',
        selected_open: false,
        selected_element: null,
        selected_event: {},

        loading: false,
      };
    },
    computed: {
      user() {
        return this.$store.getters.getUser;
      },
    },
    created() {
      this.addedVacation();
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
        if (this.user.id === event.details.vacation.user_id) {
          const open = () => {
            this.selected_event = event
            this.selected_element = nativeEvent.target
            setTimeout(() => this.selected_open = true, 10)
          }

          if (this.selected_open) {
            this.selected_open = false
            setTimeout(open, 10)
          } else {
            open()
          }

          nativeEvent.stopPropagation()
        }
      },

      allVacationApi() {
        return axios.get('/api/vacation');
      },

      async appendEvents() {
        try {
          this.loading = true;

          const events = [];
          const vacations = (await this.allVacationApi()).data.vacations;

          vacations.forEach(vacation => {
            events.push(this.prepareVacationToRender(vacation));
          });

          this.events = events;
        } catch (e) {
          console.error(e);
        } finally {
          this.loading = false;
        }

        return this;
      },

      /**
       * @returns {Object} Vue Component
       */
      async addedVacation() {
        await this.appendEvents();

        return this;
      },

      /**
       * @returns {Object} Vue Component
       */
      async editedVacation() {
        await this.appendEvents();

        return this;
      },

      prepareVacationToRender(vacation) {
        return {
          details: {
            vacation: vacation,
          },
          name: this.getVacationName(vacation),
          start: moment(vacation.start).valueOf(),
          end: moment(vacation.end).valueOf(),
          color: this.getVacationColor(vacation),
        };
      },

      getVacationName(vacation) {
        return vacation.readonly ? this.event_name_approved : this.event_name_waiting;
      },

      getVacationColor(vacation) {
        return vacation.readonly ? this.event_color.approved : this.event_color.waiting;
      },

      /**
       * Рандомное число из диапазона
       *
       * @param {number} a
       * @param {number}b
       * @returns {number}
       */
      rnd(a, b) {
        return Math.floor((b - a + 1) * Math.random()) + a
      },
    },
  }

</script>
