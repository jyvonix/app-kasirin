import defaultTheme from 'tailwindcss/defaultTheme';

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
            // Menambahkan Palet Warna "Kasirin"
            colors: {
                kasirin: {
                    50:  '#E6E6FA', // Paling terang
                    100: '#D8BFD8',
                    200: '#DDA0DD',
                    300: '#DA70D6',
                    400: '#BA55D3',
                    500: '#9932CC', // Warna Utama
                    600: '#6A5ACD', // Warna Gelap
                }
            }
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
    ],
};