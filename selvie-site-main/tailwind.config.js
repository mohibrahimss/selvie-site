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
    ],

    theme: {
        extend: {
            colors: {
                primary: {
                    50: '#f0f5ff',
                    100: '#e0eaff',
                    200: '#c7d9ff',
                    300: '#a3bfff',
                    400: '#799cff',
                    500: '#5b81c1',
                    600: '#4a6da3',
                    700: '#3d5a8a',
                    800: '#2f4569',
                    900: '#1f2d45',
                    950: '#0f1623',
                },
                secondary: {
                    50: '#fff5f2',
                    100: '#ffe6e1',
                    200: '#ffd1c7',
                    300: '#ffb3a3',
                    400: '#f37863',
                    500: '#e1654f',
                    600: '#c54e39',
                    700: '#a13a2a',
                    800: '#832e22',
                    900: '#6a251c',
                    950: '#3a120e',
                },
                gray: {
                    50: '#f9fafb',
                    100: '#f3f4f6',
                    200: '#e5e7eb',
                    300: '#d1d5db',
                    400: '#9ca3af',
                    500: '#6b7280',
                    600: '#4b5563',
                    700: '#374151',
                    800: '#1f2937',
                    900: '#111827',
                    950: '#030712',
                },
            },
            fontFamily: {
                sans: ['Inter', ...defaultTheme.fontFamily.sans],
            },
            borderRadius: {
                'xl': '1rem',
                '2xl': '1.5rem',
                '3xl': '2rem',
            },
            boxShadow: {
                'soft': '0 2px 15px -3px rgba(0, 0, 0, 0.07), 0 10px 20px -2px rgba(0, 0, 0, 0.04)',
                'soft-lg': '0 10px 25px -3px rgba(0, 0, 0, 0.07), 0 20px 45px -2px rgba(0, 0, 0, 0.04)',
            },
            animation: {
                'gradient': 'gradient 8s ease infinite',
            },
            keyframes: {
                gradient: {
                    '0%, 100%': {
                        'background-size': '200% 200%',
                        'background-position': 'left center'
                    },
                    '50%': {
                        'background-size': '200% 200%',
                        'background-position': 'right center'
                    },
                },
            },
        },
    },

    plugins: [forms, typography],
};
