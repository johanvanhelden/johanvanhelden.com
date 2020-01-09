import dayjs from 'dayjs';

export const formats = {
    date: 'DD-MM-YYYY',
    time: 'HH:mm',
    year: 'YYYY',
    shortMonth: 'MMM',
    day: 'DD'
};

/**
 * Get the formatted date.
 *
 * @param {string} date
 *
 * @return {string}
 */
export function date(date) {
    if (date === null || date === undefined) {
        return;
    }

    return dayjs(date).format(formats.date);
}

/**
 * Get the formatted time.
 *
 * @param {string} date
 *
 * @return {string}
 */
export function time(date) {
    return dayjs(date).format(formats.time);
}

/**
 * Get the formatted day.
 *
 * @param {string} date
 *
 * @return {string}
 */
export function day(date) {
    return dayjs(date).format(formats.day);
}

/**
 * Get the formatted month in it's short human readable form.
 *
 * @param {string} date
 *
 * @return {string}
 */
export function shortMonth(date) {
    return dayjs(date).format(formats.shortMonth);
}

/**
 * Get the formatted year.
 *
 * @param {string} date
 *
 * @return {string}
 */
export function year(date) {
    return dayjs(date).format(formats.year);
}

/**
 * Get the unix timestamp (in seconds).
 *
 * @param  {string} date
 *
 * @return {int}
 */
export function unix(date) {
    return dayjs(date).unix();
}
