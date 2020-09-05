<template>
  <v-menu>
    <template v-slot:activator="{ on }">
      <v-text-field
        v-model="formatted_selected_date"
        :label="label"
        prepend-icon="event"
        :disabled="disabled"
        :required="required"
        readonly
        v-on="on"
      />
    </template>
    <v-date-picker
      locale="ru"
      first-day-of-week="1"
      :value="value"
      :min="min"
      :max="max"
      :disabled="disabled"
      color="green lighten-1"
      @input="emitDate"
    />
  </v-menu>
</template>

<script>

  /**
   * Libs
   */
  import moment from 'moment';

  export default {
    name: 'DatePicker',
    props: {
      label: {
        type: String,
        default: 'Выбор даты',
      },
      min: {
        type: String,
        default: undefined,
      },
      max: {
        type: String,
        default: undefined,
      },
      value: {
        type: String,
        default: () => moment().format('YYYY-MM-DD'),
      },
      disabled: {
        type: Boolean,
        default: false,
      },
      required: {
        type: Boolean,
        default: false,
      },
    },
    computed: {
      formatted_selected_date() {
        return moment(this.value).format('DD.MM.YYYY')
      },
    },
    methods: {

      /**
       * Экспортирует строку даты (пример: 2020-02-29)
       *
       * @param date
       * @return this
       */
      emitDate(date) {
        this.$emit('input', date);

        return this;
      },
    },
  }
</script>
