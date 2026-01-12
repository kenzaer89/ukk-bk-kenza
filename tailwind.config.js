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
                    dark: '#111827', // Gray 900 - Deeper, more neutral dark
                    gray: '#1F2937', // Gray 800 - Lighter card bg
                    teal: '#2DD4BF', // Teal 400 - Vibrant teal
                    light: '#F3F4F6', // Gray 100 - Crisp white/light
                }
            }
        },
    },

    plugins: [forms],
};
