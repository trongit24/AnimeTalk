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
                sans: ['Poppins', 'Nunito', 'Inter', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'anime-sky': '#87CEEB',
                'anime-sky-light': '#B4E4FF',
                'anime-blue': '#A0D8EF',
                'anime-mint': '#B8E6D5',
                'anime-pink': '#FFE4E9',
                'anime-cream': '#FFFEF7',
                'anime-yellow': '#FFF4CC',
                'anime-peach': '#FFD4B8',
            },
            borderRadius: {
                'soft': '1rem',
                'anime': '1.5rem',
                'bubble': '2rem',
            },
            boxShadow: {
                'soft': '0 2px 8px rgba(0, 0, 0, 0.08)',
                'anime': '0 4px 12px rgba(135, 206, 235, 0.15)',
                'bubble': '0 2px 10px rgba(160, 216, 239, 0.2)',
            },
        },
    },

    plugins: [
        forms,
        require('daisyui'),
    ],

    daisyui: {
        themes: [
            {
                'anime-day': {
                    'primary': '#A0D8EF',
                    'primary-focus': '#87CEEB',
                    'primary-content': '#ffffff',
                    'secondary': '#B8E6D5',
                    'secondary-focus': '#9FD9C2',
                    'secondary-content': '#ffffff',
                    'accent': '#FFE4E9',
                    'accent-focus': '#FFCCD5',
                    'accent-content': '#333333',
                    'neutral': '#F5F5F5',
                    'neutral-focus': '#E8E8E8',
                    'neutral-content': '#333333',
                    'base-100': '#FFFEF7',
                    'base-200': '#FFF9F0',
                    'base-300': '#F0F0F0',
                    'base-content': '#333333',
                    'info': '#A0D8EF',
                    'success': '#B8E6D5',
                    'warning': '#FFF4CC',
                    'error': '#FFB8B8',
                    '--rounded-box': '1.5rem',
                    '--rounded-btn': '1rem',
                    '--rounded-badge': '1rem',
                    '--animation-btn': '0.3s',
                    '--animation-input': '0.3s',
                    '--btn-focus-scale': '1.02',
                    '--border-btn': '1px',
                    '--tab-border': '1px',
                    '--tab-radius': '1rem',
                },
            },
            "light",
            "cupcake",
        ],
        darkTheme: false,
        base: true,
        styled: true,
        utils: true,
    },
};
