const plugin = require('tailwindcss/plugin');

module.exports = {
    content: ['./**/*.php', './src/**/*.js'],
    important: true,
    darkMode: 'class',
    theme: {
        lineWeight: {
            1: '1px',
            2: '2px',
            3: '3px',
        },
        iconWeight: {
            1: '1px',
            2: '2px',
            3: '3px',
        },
        container: {
            center: true,
        },
        screens: {
            sm: '641px',
            md: '769px',
            lg: '1025px',
            xl: '1281px',
            '2xl': '1440px',
            '3xl': '1921px',
        },
        fontFamily: {
            sans: ['"Haffer"', 'sans-serif'],
        },
        extend: {
            colors: {
                'prosek-orange': 'var(--prosek-orange)',
                'prosek-dull-gold': 'var(--prosek-dull-gold)',
                'prosek-light-gray': 'var(--prosek-light-gray)',
                'navy-blue': 'var(--navy-blue)',
                'bright-blue': 'var(--bright-blue)',
                'off-black': 'var(--off-black)',
                'light-blue': 'var(--light-blue)',
                'divider-line-blue': 'var(--divider-line-blue)',
                'medium-gray': 'var(--medium-gray)',
                'success': 'var(--success)',
                'alert': 'var(--alert)',
                'disabled': 'var(--disabled)',
            },
            height: {
                'full-body': 'calc(100vh - var(--header-height) - var(--wp-admin--admin-bar--height, 0px))',
            },
            padding: {
                'container-top': 'var(--container-top-padding)',
                'container-bottom': 'var(--container-bottom-padding)',
                'container-left': 'var(--container-left-padding)',
                'container-right': 'var(--container-right-padding)',
                'container-sm-top': 'var(--container-sm-top-padding)',
                'container-sm-bottom': 'var(--container-sm-bottom-padding)',
                'container-sm-left': 'var(--container-sm-left-padding)',
                'container-sm-right': 'var(--container-sm-right-padding)',
                'container-md-top': 'var(--container-md-top-padding)',
                'container-md-bottom': 'var(--container-md-bottom-padding)',
                'container-md-left': 'var(--container-md-left-padding)',
                'container-md-right': 'var(--container-md-right-padding)',
                'side-offset': 'var(--side-offset)',
            },
            margin: {
                'container-top': 'var(--container-top-padding)',
                'container-bottom': 'var(--container-bottom-padding)',
                'container-left': 'var(--container-left-padding)',
                'container-right': 'var(--container-right-padding)',
                'container-sm-top': 'var(--container-sm-top-padding)',
                'container-sm-bottom': 'var(--container-sm-bottom-padding)',
                'container-sm-left': 'var(--container-sm-left-padding)',
                'container-sm-right': 'var(--container-sm-right-padding)',
                'container-md-top': 'var(--container-md-top-padding)',
                'container-md-bottom': 'var(--container-md-bottom-padding)',
                'container-md-left': 'var(--container-md-left-padding)',
                'container-md-right': 'var(--container-md-right-padding)',
                'side-offset': 'var(--side-offset)',
            },
            boxShadow: {
                up: '0 -8px 20px rgba(0,0,0,0.2)',
            },
        },
    },
    plugins: [
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'multi-underline': (value) => ({
                        '--line-weight': value,
                        '@apply bg-gradient-to-r from-current to-current bg-[length:0_var(--line-weight)] bg-left-bottom bg-no-repeat no-underline !transition-[background] !duration-700': {},
                        '@apply hover:bg-[length:100%_var(--line-weight)] focus:bg-[length:100%_var(--line-weight)] [a:hover_&]:bg-[length:100%_var(--line-weight)]': {},
                    }),
                },
                {
                    values: theme('lineWeight'),
                },
            );
        }),
        plugin(function ({ matchUtilities, theme }) {
            matchUtilities(
                {
                    'accordion-icon': (value) => ({
                        '--accordion-icon-weight': value,
                        '@apply relative will-change-transform block shrink-0 transition-transform rotate-0 duration-300 [button:hover_&]:rotate-90 [.is-active_&]:rotate-90 [.is-active_&]:before:rotate-90': {},
                        '@apply before:absolute before:left-0 before:top-1/2 before:-translate-y-1/2 before:w-full before:h-[--accordion-icon-weight,3px] before:bg-current before:rounded-full before:rotate-0 before:transition-transform': {},
                        '@apply after:absolute after:left-0 after:top-1/2 after:-translate-y-1/2 after:w-full after:h-[--accordion-icon-weight,3px] after:bg-current after:rotate-90 after:rounded-full': {},
                    }),
                },
                {
                    values: theme('iconWeight'),
                },
            );
        }),
    ],
};
