import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './public/js/app.js',
        './app/View/Components/*.php',
        './app/Http/Controllers/**/*.php',
        "./node_modules/flowbite/**/*.js",
    ],
    safelist: [
        {
            pattern: /^(bg|border|text)-(pink|red|yellow|indigo|blue|green|gray|purple|teal)-(50|100|200|300|400|500|600|700|800|900|950)$/,
        }
    ],
    theme: {
        extend: {
            container: {
                center: true
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'gs-red': '#a90432',
                'gs-red-2': '#DB2424',
            }
        },

    },
    plugins: [
        require('flowbite/plugin')({
            datatables: true,
        }),
        require('tailwindcss-pseudo-elements'),
    ],
    darkMode: 'false',
};
