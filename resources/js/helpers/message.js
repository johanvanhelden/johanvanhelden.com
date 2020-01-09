/**
 * Show a proper error message for the end-user.
 *
 * @param {number} status
 *
 * @return {string}
 */
export function errorMessage(status) {
    let specificMessages = {
        503: "Hang on. We'll be right back.",
        404: 'This page could not be found.',
        403: 'You are not allowed to perform this action.'
    };

    if (specificMessages[status]) {
        return specificMessages[status];
    }

    return 'Something went wrong. Please try again later.';
}
