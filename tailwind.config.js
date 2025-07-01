/** @type {import('tailwindcss').Config} */
const defaultTheme = require("tailwindcss/defaultTheme");
const forms = require("@tailwindcss/forms");

module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
    ],
    theme: {
        extend: {
            colors: {
                // Colores institucionales y personalizados combinados
                "blue-institutional": "#1E3A8A", // Confianza, profesionalismo (equivale a primary)
                primary: "#1E3A8A",
                "primary-dark": "#142d6d",
                "blue-secondary": "#3B82F6", // Tecnología, innovación (equivale a secondary)
                secondary: "#3B82F6",
                "yellow-accent": "#F59E0B", // Energía, optimismo (referencia bandera Ecuador)
                accent: "#F59E0B",
                "accent-dark": "#E08D00",
                "gray-corporate": "#374151", // Neutralidad, elegancia (equivale a dark)
                dark: "#374151",
                "gray-light": "#F3F4F6",
                "text-main": "#1B1B18",
                "text-light": "#6B7280",

                // Colores adicionales para logo o branding nuevo
                "logo-primary": "#0D326F", // Azul oscuro logo nuevo, separado para evitar confusión
                "logo-blue-200": "#BFD7ED", // Azul muy claro logo nuevo
            },
            fontFamily: {
                // Manteniendo ambas configuraciones y agregando alias claros
                sans: ["Figtree", ...defaultTheme.fontFamily.sans], // default sans con Figtree al inicio
                montserrat: ["Montserrat", "sans-serif"],
                "open-sans": ["Open Sans", "sans-serif"],
                inter: ["Inter", "sans-serif"],
                // Alias usados en la segunda config para consistencia
                headings: ["Montserrat", "sans-serif"],
                alt: ["Inter", "sans-serif"],
            },
            boxShadow: {
                "3xl": "0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 15px 30px -5px rgba(0, 0, 0, 0.25)",
            },
        },
    },
    plugins: [forms],
};
