import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';
import typography from '@tailwindcss/typography';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './app/Filament/**/*.php',
        './resources/views/filament/**/*.blade.php',
        './vendor/filament/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Noto Sans Khmer', ...defaultTheme.fontFamily.sans],
                khmer: ['Noto Sans Khmer', 'sans-serif'],
            },
            fontSize: {
                'khmer-sm': ['14px', '1.7'],
                'khmer-base': ['16px', '1.7'],
                'khmer-lg': ['18px', '1.7'],
                'khmer-xl': ['20px', '1.7'],
            },
        },
    },

    plugins: [forms, typography],
};
