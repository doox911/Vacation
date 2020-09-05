<template>
  <v-row justify="center">
    <v-dialog
      v-model="show_dialog"
      persistent
      max-width="600px"
    >
      <template v-slot:activator="{ on, attrs }">
        <v-btn
          :color="color"
          small
          :title="title"
          v-bind="attrs"
          v-on="on"
        >
          {{ title }}
        </v-btn>
      </template>

      <v-card>
        <v-card-title class="title green lighten-2 white--text user-select-none font-weight-regular">
          <v-row>
            <v-col class="pt-2">
              {{ title }}
            </v-col>
          </v-row>
        </v-card-title>
        <v-card-text>
          <v-row>
            <v-col>
              Выбирите дту начала и конца отпуска
            </v-col>
          </v-row>
          <v-row>
            <v-col>
              <data-picker
                label="Начало отпуска"
                v-model="selected_start_date"
              />
            </v-col>
            <v-col>
              <data-picker
                label="Конец отпуска"
                v-model="selected_end_date"
              />
            </v-col>
          </v-row>
        </v-card-text>
        <v-card-actions>
          <v-spacer/>
          <v-btn
            color="error"
            :loading="loading || local_loading"
            @click="toggleDialog"
          >
            Отмена
          </v-btn>
          <v-btn
            color="success"
            :loading="loading || local_loading"
            @click="toggleDialog"
          >
            Добавить
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </v-row>
</template>

<script>

  /**
   * Libs
   */
  import moment from 'moment';
  /**
   * Components
   */
  import DataPicker from '../DataPicker';

  /**
   * Добавить даты отпуска
   */
  export default {
    name: 'AddVacation',
    components: {
      DataPicker,
    },
    props: {
      title: {
        type: String,
        default: 'Добавить отпуск',
      },
      color: {
        type: String,
        default: 'primary',
      },
      loading: {
        type: Boolean,
        default: false,
      },
    },
    data() {
      return {
        show_dialog: false,
        invoice_id: 0,
        local_loading: false,

        /**
         * @description Выбрать начало отпуска можно за неделю до
         */
        selected_start_date: moment().add(7, 'days').format('YYYY-MM-DD'),
        selected_end_date: moment().add(8, 'days').format('YYYY-MM-DD'),
      }
    },
    methods: {

      /**
       * Переключатель модального окна
       *
       * @returns {Object} Vue Component
       */
      toggleDialog() {
        this.show_dialog = !this.show_dialog;

        return this;
      },
    },
  }
</script>

