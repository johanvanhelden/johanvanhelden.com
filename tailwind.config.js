module.exports = {
    theme: {
        extend: {
            colors: {
                gray: {
                    100: '#f7fafc',
                    200: '#edf2f7',
                    300: '#e2e8f0',
                    400: '#cbd5e0',
                    500: '#a0aec0',
                    600: '#718096',
                    700: '#4a5568',
                    800: '#2d3748',
                    900: '#1a202c',
                },
                blue: {
                    100: '#ebf8ff',
                    200: '#bee3f8',
                    300: '#90cdf4',
                    400: '#63b3ed',
                    500: '#4299e1',
                    600: '#3182ce',
                    700: '#2b6cb0',
                    800: '#2c5282',
                    900: '#2a4365',
                },
                primary:  {
                    lightest: '#e8f3fc',
                    light: '#1780D4',
                    DEFAULT: '#19639e',
                    dark: '#08406e',
                },
                secondary:  {
                    DEFAULT: '#2D3748',
                }
            },
            backgroundPosition: {
                'center-top': 'center top',
            },
            typography: (theme) => ({
                DEFAULT: {
                  css: {
                    color: theme('colors.gray.700'),
                    h1: {
                        color: theme('colors.gray.700'),
                    },
                    h2: {
                        color: theme('colors.gray.700'),
                    },
                    h3: {
                        color: theme('colors.gray.700'),
                    },
                    h4: {
                        color: theme('colors.gray.700'),
                    },
                    h5: {
                        color: theme('colors.gray.700'),
                    },
                    h6: {
                        color: theme('colors.gray.700'),
                    },
                    a: {
                        color: theme('colors.blue.800'),
                        fontWeight: theme('fontWeight.semibold'),
                        textDecoration: 'none',
                        '&:hover': {
                            textDecoration: 'underline',
                        },
                    },
                  },
                },
            }),
        },
    },
    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
    ],
    content: [
        './resources/**/*.blade.php',
    ],
}
