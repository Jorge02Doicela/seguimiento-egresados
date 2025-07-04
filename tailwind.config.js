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
                // Colores del primer config
                primary: "#1E3A8A", // Azul Oscuro ISUS
                "primary-dark": "#152C6E", // Azul un poco más oscuro (de primer config)
                "primary-light": "#3B82F6", // Azul Principal ISUS
                "primary-lighter": "#6AA1F8", // Azul aún más claro
                secondary: "#3B82F6", // Azul Principal ISUS
                "yellow-accent": "#F59E0B", // Amarillo de Acento ISUS
                "yellow-accent-light": "#FCD34D", // Amarillo más claro
                "yellow-accent-lighter": "#FDE68A", // Amarillo aún más claro
                dark: "#1F2937", // Gris muy oscuro para texto (primer config)
                "text-light": "#4B5563", // Gris más claro para texto (primer config)
                "gray-light": "#F8F9FA", // Fondo muy claro (primer config)

                // Colores del segundo config (si quieres usar estos valores, adapta el color key)
                "primary-dark": "#142d6d", // segundo config, cuidado con duplicados
                "blue-institutional": "#1E3A8A", // equivale a primary
                "blue-secondary": "#3B82F6",
                accent: "#F59E0B",
                "accent-dark": "#E08D00",
                "gray-corporate": "#374151",
                dark: "#374151", // sobrescribe el anterior dark
                "gray-light": "#F3F4F6", // sobrescribe primer gray-light
                "text-main": "#1B1B18",
                "text-light": "#6B7280", // sobrescribe primer text-light

                // Colores adicionales segundo config
                "logo-primary": "#0D326F",
                "logo-blue-200": "#BFD7ED",
            },
            fontFamily: {
                headings: ["Montserrat", "sans-serif"],
                "open-sans": ["Open Sans", "sans-serif"],
                sans: ["Figtree", ...defaultTheme.fontFamily.sans],
                montserrat: ["Montserrat", "sans-serif"],
                inter: ["Inter", "sans-serif"],
                alt: ["Inter", "sans-serif"],
            },
            boxShadow: {
                // Del primer config
                "3xl": "0 35px 60px -15px rgba(0, 0, 0, 0.3)",
                "4xl": "0 25px 50px -12px rgba(0, 0, 0, 0.4)",
                // Del segundo config (puedes modificar el valor si quieres combinar o escoger uno)
                "3xl": "0 25px 50px -12px rgba(0, 0, 0, 0.35), 0 15px 30px -5px rgba(0, 0, 0, 0.25)",
            },
            keyframes: {
                "fade-in-down": {
                    "0%": { opacity: "0", transform: "translateY(-20px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                "fade-in-up": {
                    "0%": { opacity: "0", transform: "translateY(20px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                "fade-in": {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                "slide-in-left": {
                    "0%": { opacity: "0", transform: "translateX(-20px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                "slide-in-right": {
                    "0%": { opacity: "0", transform: "translateX(20px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                "pop-in": {
                    "0%": { opacity: "0", transform: "scale(0.8)" },
                    "80%": { opacity: "1", transform: "scale(1.05)" },
                    "100%": { transform: "scale(1)" },
                },
                "pulse-slow": {
                    "0%, 100%": { opacity: "1" },
                    "50%": { opacity: "0.7" },
                },
            },
            animation: {
                "fade-in-down": "fade-in-down 0.6s ease-out forwards",
                "fade-in-up": "fade-in-up 0.6s ease-out forwards",
                "fade-in": "fade-in 0.6s ease-out forwards",
                "slide-in-left": "slide-in-left 0.6s ease-out forwards",
                "slide-in-right": "slide-in-right 0.6s ease-out forwards",
                "pop-in": "pop-in 0.7s ease-out forwards",
                "pulse-slow": "pulse-slow 2s infinite",
            },
        },
    },
    plugins: [forms],
};
