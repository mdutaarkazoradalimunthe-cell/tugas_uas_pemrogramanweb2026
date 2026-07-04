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
            colors: {
                paper: '#F8F5EF',
                ink: '#21261F',
                evergreen: {
                    DEFAULT: '#1F4D3A',
                    dark: '#17392B',
                },
                brass: {
                    DEFAULT: '#B48A4A',
                    light: '#D8C39A',
                },
                blush: {
                    DEFAULT: '#C97878',
                    dark: '#A85E5E',
                },
                mist: '#E7E1D6',
            },
            fontFamily: {
                display: ['Fraunces', 'serif'],
                sans: ['Inter', 'sans-serif'],
                mono: ['"IBM Plex Mono"', 'monospace'],
            },
        },
    },

    plugins: [forms],
};
