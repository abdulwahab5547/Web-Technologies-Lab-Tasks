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
            colors: {
                brand: {
                    50:  '#eff4ff',
                    100: '#dbe8ff',
                    200: '#bfd4ff',
                    300: '#93b4fd',
                    400: '#6089fa',
                    500: '#2862FF',
                    600: '#1a4fd6',
                    700: '#1640b0',
                    800: '#18368e',
                    900: '#1a3170',
                    950: '#131f47',
                },
            },
        },
    },

    plugins: [forms],
};
