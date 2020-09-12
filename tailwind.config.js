const { colors } = require('tailwindcss/defaultTheme')

module.exports = {
    theme: {
        colors: {
            black: colors.black,
            white: colors.white,
            gray: colors.gray,
            blue: colors.blue,
            red: colors.red,
            green: colors.green,
            // yellow: colors.yellow,
            // indigo: colors.indigo,
            // purple: colors.purple,
            // teal: colors.teal,
            // orange: colors.orange,
            // pink: colors.pink,
        },
        backgroundPosition: {
            bottom: 'bottom',
            center: 'center',
            'center-top': 'center top',
            left: 'left',
            'left-bottom': 'left bottom',
            'left-top': 'left top',
            right: 'right',
            'right-bottom': 'right bottom',
            'right-top': 'right top',
            top: 'top',
        },
        screens: {
            'sm': '640px',
            'md': '768px',
            'lg': '1024px',
        },
        extend: {}
    },
    variants: {
        cursor: ['responsive', 'hover'],
    },
    plugins: [],
    corePlugins: {
        float: false,
        objectFit: false,
        objectPosition: false,
    },
    purge: false
}
