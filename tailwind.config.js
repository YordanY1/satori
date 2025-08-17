// tailwind.config.js
/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                primary: "#2E3A59",
                accent: "#C69B5E",
                secondary: "#4E6E58",
                background: "#FAF7F2",
                text: "#1F1F1F",
                danger: "#B33F40",
                neutral: "#E6E2DD",
            },
        },
    },
    plugins: [],
};
