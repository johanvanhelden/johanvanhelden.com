/**
 * @see https://stylelint.io/user-guide/configure/
 *
 * @type { import('stylelint').Config }
 */
export default {
    extends: ['stylelint-config-standard'],

    rules: {
        'at-rule-no-unknown': [
            true,
            {
                ignoreAtRules: ['custom-variant', 'theme', 'utility', 'plugin', 'source'],
            },
        ],
        'at-rule-no-deprecated': [
            true,
            {
                ignoreAtRules: ['apply'],
            },
        ],
    },
};
