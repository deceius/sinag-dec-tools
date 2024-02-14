import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            typography: ({ theme }) => ({
                DEFAULT: {
                  css: {
                    '--tw-prose-body': theme('colors.gray[400]'),
                    '--tw-prose-headings': theme('colors.gray[200]'),
                    '--tw-prose-lead': theme('colors.gray[700]'),
                    '--tw-prose-links': theme('colors.indigo[600]'),
                    '--tw-prose-bold': theme('colors.gray[200]'),
                    '--tw-prose-counters': theme('colors.gray[400]'),
                    '--tw-prose-bullets': theme('colors.gray[400]'),
                    '--tw-prose-hr': theme('colors.gray[400]'),
                    '--tw-prose-quotes': theme('colors.gray[600]'),
                    '--tw-prose-quote-borders': theme('colors.gray[600]'),
                    '--tw-prose-captions': theme('colors.gray[700]'),
                    '--tw-prose-code': theme('colors.gray[600]'),
                    '--tw-prose-pre-code': theme('colors.gray[600]'),
                    '--tw-prose-pre-bg': theme('colors.gray[200]'),
                    '--tw-prose-th-borders': theme('colors.gray[400]'),
                    '--tw-prose-td-borders': theme('colors.gray[400]'),
                    '--tw-prose-invert-body': theme('colors.gray[200]'),
                    '--tw-prose-invert-headings': theme('colors.white'),
                    '--tw-prose-invert-lead': theme('colors.gray[300]'),
                    '--tw-prose-invert-links': theme('colors.white'),
                    '--tw-prose-invert-bold': theme('colors.white'),
                    '--tw-prose-invert-counters': theme('colors.gray[400]'),
                    '--tw-prose-invert-bullets': theme('colors.gray[600]'),
                    '--tw-prose-invert-hr': theme('colors.gray[700]'),
                    '--tw-prose-invert-quotes': theme('colors.gray[100]'),
                    '--tw-prose-invert-quote-borders': theme('colors.gray[700]'),
                    '--tw-prose-invert-captions': theme('colors.gray[400]'),
                    '--tw-prose-invert-code': theme('colors.white'),
                    '--tw-prose-invert-pre-code': theme('colors.gray[300]'),
                    '--tw-prose-invert-pre-bg': 'rgb(0 0 0 / 50%)',
                    '--tw-prose-invert-th-borders': theme('colors.gray[600]'),
                    '--tw-prose-invert-td-borders': theme('colors.gray[700]'),
                  },
                },
              }),
        },
    },

    plugins: [forms,
        require('@tailwindcss/typography'),
    ],
};
