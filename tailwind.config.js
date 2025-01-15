import defaultTheme from 'tailwindcss/defaultTheme';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
        './app/View/Components/*.php',
        "./node_modules/flowbite/**/*.js",
    ],
    safelist: [
        {
            pattern: /^(bg|border)-(pink|red|yellow|indigo|blue|green|gray|purple|teal)-(300|400)$/
        },
        'justify-self-end', 'justify-self-center', 'justify-self-start',
        'even:bg-gray-50',
        '-mr-px',
        'leading-6',
        'active:z-10',
        'z-10',
        "inline-flex",
        "border",
        "-mr-px",
        "leading-6",
        "hover:z-10",
        "focus:z-10",
        "active:z-10",
        "border-gray-200",
        "active:border-gray-200",
        "active:shadow-none",
        "bg-white",
        "dark:bg-gray-800",
        "text-gray-800",
        "hover:text-gray-900",
        "hover:border-gray-300",
        "hover:shadow-sm",
        "focus:ring",
        "focus:ring-gray-300",
        "focus:ring-opacity-25",
        "first",
        "rounded-l-lg",
        "last",
        "rounded-r-lg"
    ],
    theme: {
        extend: {
            container: {
                center: true
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },

    },
    plugins: [
        require('flowbite/plugin')({
            datatables: true,
        }),
    ],
    darkMode: 'false',
};
