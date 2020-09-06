import moment from 'moment';

/**
 * @param {string} start_date
 * @param {string} end_date
 * @returns {boolean}
 */
function validateDates(start_date, end_date) {
  const standard = moment().add(6, 'days');
  const start = moment(start_date);
  const end = moment(end_date);

  const rule_1 = standard < start;
  const rule_2 = standard < end;
  const rule_3 = end > start;

  return rule_1 && rule_2 && rule_3;
};

export {
  validateDates,
}
