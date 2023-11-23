const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/layouts/navigation.blade.php',
        "./resources/views/index.blade.php",
        "./resources/views/show.blade.php",
        "./resources/views/create.blade.php",
        "./resources/views/detailShow.blade.php",
        "./resources/views/relay.blade.php",
        "./resources/views/shopShow.blade.php",
        "./resources/views/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js"
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('flowbite/plugin')
        
        ],
};
