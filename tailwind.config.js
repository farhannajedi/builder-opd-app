import defaultTheme from "tailwindcss/defaultTheme";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],
    theme: {
        extend: {
            colors: {
                brand: {
                    DEFAULT: "var(--color-primary)",
                    hover: "var(--color-primary)",
                    light: "var(--color-primary)",
                    border: "var(--color-primary)",
                },
            },
        },
    },
    plugins: [],
};
