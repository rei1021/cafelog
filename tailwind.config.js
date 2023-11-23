const defaultTheme = require('tailwindcss/defaultTheme');

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/layouts/navigation.blade.php',
        "./resources/views/reviews/index.blade.php",
        "./resources/views/reviews/show.blade.php",
        "./resources/views/reviews/create.blade.php",
        "./resources/views/reviews/detailShow.blade.php",
        "./resources/views/reviews/relay.blade.php",
        "./resources/views/reviews/shopShow.blade.php",
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
