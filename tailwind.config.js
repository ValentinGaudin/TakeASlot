const colors = require('tailwindcss/colors');
/* eslint-disable global-require */
module.exports = {
    content: [
        './templates/**/*.twig',
        './assets/**/*.scss',
        './assets/**/*.js',
    ],
    darkMode: 'media',
    justifyContent: ['hover', 'focus'],
    theme: {
        extend: {
            fontFamily: {
                body: ['sans-serif'],
            },
            colors: {
                transparent: 'transparent',
                current: 'currentColor',
                white: '#ffffff',
                primary: {
                    light: '#d90920',
                    DEFAULT: '#900615',
                    dark: '#47030a',
                },
                secondary: {
                    light: '#bb0e06',
                    DEFAULT: '#f82015',
                    dark: '#fa675f',
                },
                ternary: {
                    light: '#feb748',
                    DEFAULT: '#f99801',
                    dark: '#ad6901',
                },
                quatuor: {
                    light: '#0ffef7',
                    DEFAULT: '#01bfba',
                    dark: '#017370',
                },
                black: {
                    light: '#7a7a7a',
                    DEFAULT: '#0e1212',
                },
            },
            backgroundImage: {
                // 'footer-texture': "url('/assets/images/footer.png')",
                'index-cover': "url('/assets/images/index.png')",
                'gears-cover': "url('/assets/images/gears.png')",
            },
        },
    },
    variants: {
        extend: {},
    },
    plugins: [require('@tailwindcss/aspect-ratio')],
};
/* eslint-enable global-require */
