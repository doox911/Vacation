<template>
  <div>
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
            :loading="loading"
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
              text
              color="secondary"
              :loading="loading || local_loading"
              @click="toggleDialog"
            >
              Отмена
            </v-btn>
            <v-btn
              text
              color="success"
              :loading="loading || local_loading"
              @click="store"
            >
              Добавить
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-row>

    <v-snackbar
      v-model="snackbar"
      :color="snackbar_color"
      right
      :timeout="snackbar_timeout"
    >
      <div v-html="snackbar_text"/>
      <template v-slot:action="{ attrs }">
        <v-btn
          dark
          text
          v-bind="attrs"
          @click="toggleSnackbar"
        >
          Закрыть
        </v-btn>
      </template>
    </v-snackbar>
  </div>
</template>

<script>

  /**
   * Libs
   */
  import moment from 'moment';
  import axios from 'axios';

  /**
   * Helpers
   */
  import {validateDates} from '../../helpers';

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
        local_loading: false,
        delay: 100,

        /**
         * Snackbar
         */
        snackbar: false,
        snackbar_color: 'info',
        snackbar_timeout: 7000,
        snackbar_text: 'Успешно',

        /**
         * @description Запрет редактирования отпуска
         */
        readonly: false,

        /**
         * @description Выбрать начало отпуска можно за неделю до
         */
        selected_start_date: moment().add(6, 'days').format('YYYY-MM-DD'),
        selected_end_date: moment().add(7, 'days').format('YYYY-MM-DD'),
      }
    },
    computed: {
      payload() {
        return {
          start: this.selected_start_date,
          end: this.selected_end_date,
          readonly: this.readonly,
        };
      },
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

      /**
       * Переключатель snackbar
       *
       * @returns {Object} Vue Component
       */
      toggleSnackbar() {
        this.snackbar = !this.snackbar;

        return this;
      },

      /**
       * @returns {Promise<Object>} Vue Component
       */
      api() {
        return axios.post(`/api/vacation`, this.payload);
      },

      /**
       * @returns {Promise<Object>}
       */
      async store() {
        try {
          if (validateDates(this.selected_start_date, this.selected_end_date)) {
            await this.api();

            this.emit();

            this.snackbar_color = 'success';
            this.snackbar_text = 'Заявка на отпуск создана';
          } else {
            this.snackbar_color = 'error';
            this.snackbar_text = `
              <p>Дата завершения отпуска не может быть меньше или равна дате начала отпуска</p>
              <p>Выбор даты возможет от текущего момента + 6 дней</p>
            `;
          }
        } catch (e) {
          this.snackbar_color = 'error';
          this.snackbar_text = 'Не верные даты отпуска';
        } finally {
          if (!this.snackbar) {
            this.toggleSnackbar()
          }

          this.toggleDialog();
        }
      },

      /**
       * @returns {Object} Vue Component
       */
      emit() {
        this.$emit('input', this.payload);

        return this;
      },
    },
  }
</script>

