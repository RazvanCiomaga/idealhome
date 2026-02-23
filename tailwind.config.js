import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
            },
            colors: {
                primary: "rgb(var(--color-primary) / <alpha-value>)",
                surface: "rgb(var(--color-surface) / <alpha-value>)",
                heading: "rgb(var(--color-heading) / <alpha-value>)",
                body: "rgb(var(--color-body) / <alpha-value>)",
                divider: "rgb(var(--color-divider) / <alpha-value>)",
            },
        },
    },
    plugins: [],
};
