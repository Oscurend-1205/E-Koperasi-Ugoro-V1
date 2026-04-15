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
                'ugoro-green': '#1e5f3f', // Dark green for important text
                'ugoro-emerald': '#34d399', // Emerald for gradients
                'ugoro-orange': '#fbbf24', // Soft orange for highlights
                'ugoro-orange-dark': '#d97706', // Darker orange for gradients
            },
        },
    },

    plugins: [forms],
};
