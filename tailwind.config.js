import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import PrimeUI from 'tailwindcss-primeui';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Sansserif', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms, PrimeUI],
};
