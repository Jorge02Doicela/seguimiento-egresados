import defaultTheme from "tailwindcss/defaultTheme";
import forms from "@tailwindcss/forms";

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
    ],

    theme: {
        extend: {
            // Definición de tus colores personalizados
            colors: {
                // Colores Primarios
                "blue-institutional": "#1E3A8A", // Confianza, profesionalismo
                "blue-secondary": "#3B82F6", // Tecnología, innovación
                // Colores Complementarios
                "gray-corporate": "#374151", // Neutralidad, elegancia
                "yellow-accent": "#F59E0B", // Energía, optimismo - referencia bandera Ecuador
            },
            // Definición de tus fuentes personalizadas
            fontFamily: {
                sans: ["Figtree", ...defaultTheme.fontFamily.sans], // Mantiene Figtree como sans-serif predeterminada
                montserrat: ["Montserrat", "sans-serif"],
                "open-sans": ["Open Sans", "sans-serif"],
                inter: ["Inter", "sans-serif"], // Para interfaces digitales o como alternativa
            },
            // Definición de la sombra 3xl
            boxShadow: {
                "3xl": "0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 15px 30px -5px rgba(0, 0, 0, 0.25)",
            },
        },
    },

    plugins: [forms],
};
