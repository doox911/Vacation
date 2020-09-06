<template>
  <v-container>
    <v-row>
      <v-col>
        <data-picker
          label="Начало отпуска"
          v-model="vacation.start"
        />
      </v-col>
      <v-col>
        <data-picker
          label="Конец отпуска"
          v-model="vacation.end"
        />
      </v-col>
      <v-col cols="1">
        <v-btn
          icon
          color="orange"
          :loading="loading || local_loading"
          @click="update"
        >
          <v-icon>mdi-pencil</v-icon>
        </v-btn>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>

  /**
   * Libs
   */
  import axios from 'axios';

  /**
   * Helpers
   */
  import {validateDates} from '../../helpers';

  /**
   * Components
   */
  import DataPicker from '../DataPicker';

  export default {
    name: 'EditVacation',
    components: {
      DataPicker,
    },
    props: {
      vacation: {
        type: Object,
        default: () => {
          return {};
        },
      },
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
        local_loading: false,

        /**
         * @description Запрет редактирования отпуска
         */
        readonly: false,
      }
    },
    methods: {

      /**
       * @returns {Promise<Object>} Vue Component
       */
      api() {
        return axios.put(`/api/vacation/${this.vacation.id}`, this.vacation);
      },

      /**
       * @returns {Promise<Object>}
       */
      async update() {
        try {
          if (validateDates(this.vacation.start, this.vacation.end) && !this.vacation.readonly) {
            await this.api();

            this.emit();

            this.snackbar_color = 'success';
            this.snackbar_text = 'Заявка на обновлена';
          } else {
            this.snackbar_color = 'error';
            this.snackbar_text = 'Дата завершения отпуска не может быть меньше или равна дате начала отпуска';
          }
        } catch (e) {
          this.snackbar_color = 'error';
          this.snackbar_text = 'Не верные даты отпуска';
        }
      },

      /**
       * @returns {Object} Vue Component
       */
      emit() {
        this.$emit('input', this.vacation);

        return this;
      },
    },
  }
</script>
