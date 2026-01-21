/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
    ],
    theme: {
        extend: {
            colors: {
                'brand-teal': '#2dd4bf',
                'brand-dark': '#0f172a',
                'brand-light': '#f8fafc',
                'brand-gray': '#1e293b',
            }
        },
    },
    plugins: [],
}
