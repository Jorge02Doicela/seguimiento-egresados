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
                // === COLORES PRIMARIOS ISUS PREMIUM ===
                primary: "#0052CC", // Azul Digital Principal
                "primary-dark": "#1E40AF", // Azul Innovación
                "primary-light": "#3B82F6", // Azul Eléctrico
                "primary-lighter": "#60A5FA", // Azul Suave
                "primary-lightest": "#DBEAFE", // Azul Muy Claro

                // === COLORES SECUNDARIOS PREMIUM ===
                secondary: "#3B82F6", // Azul Eléctrico (consistente)
                "secondary-dark": "#2563EB",
                "secondary-light": "#60A5FA",

                // === COLORES DE ACENTO ENERGÉTICOS (Mostazita más claro) ===
                accent: "#F97316", // Naranja más claro (original era #EA580C)
                "accent-dark": "#E25800", // Tono oscuro ajustado
                "accent-light": "#FDBA74", // Naranja más claro (original era #FB923C)
                "accent-lighter": "#FFEDD5", // Naranja Muy Claro, aún más suave (original era #FED7AA)

                // === COLORES COMPLEMENTARIOS ===
                success: "#059669", // Verde Crecimiento
                "success-dark": "#047857",
                "success-light": "#10B981",
                "success-lighter": "#A7F3D0",

                warning: "#F59E0B", // Amarillo Advertencia
                "warning-dark": "#D97706",
                "warning-light": "#FCD34D",
                "warning-lighter": "#FEF3C7",

                error: "#DC2626", // Rojo Error
                "error-dark": "#B91C1C",
                "error-light": "#EF4444",
                "error-lighter": "#FECACA",

                innovation: "#7C3AED", // Púrpura Innovación
                "innovation-dark": "#6D28D9",
                "innovation-light": "#8B5CF6",
                "innovation-lighter": "#DDD6FE",

                // === GRISES PREMIUM ===
                "gray-carbon": "#1F2937", // Gris Carbón
                "gray-slate": "#374151", // Gris Pizarra
                "gray-silver": "#6B7280", // Gris Plata
                "gray-light": "#F3F4F6", // Gris Claro
                "gray-lighter": "#F9FAFB", // Gris Muy Claro
                "gray-lightest": "#FEFEFE", // Casi Blanco

                // === COLORES DE TEXTO OPTIMIZADOS ===
                "text-primary": "#1F2937", // Texto Principal
                "text-secondary": "#374151", // Texto Secundario
                "text-muted": "#6B7280", // Texto Desenfatizado
                "text-light": "#7D8795", // Texto Claro (Ajustado a un tono más oscuro que #9CA3AF)
                "text-inverse": "#FFFFFF", // Texto Inverso

                // === COLORES DE FONDO ===
                "bg-primary": "#FFFFFF", // Fondo Principal
                "bg-secondary": "#F9FAFB", // Fondo Secundario
                "bg-tertiary": "#F3F4F6", // Fondo Terciario
                "bg-dark": "#1F2937", // Fondo Oscuro
                "bg-overlay": "rgba(31, 41, 55, 0.75)", // Overlay

                // === COLORES DE BORDE ===
                "border-primary": "#E5E7EB", // Borde Principal
                "border-secondary": "#D1D5DB", // Borde Secundario
                "border-accent": "#0052CC", // Borde Acento
                "border-success": "#059669", // Borde Éxito
                "border-warning": "#F59E0B", // Borde Advertencia
                "border-error": "#DC2626", // Borde Error

                // === COLORES INSTITUCIONALES (LEGACY) ===
                "blue-institutional": "#1E3A8A", // Compatibilidad
                "blue-secondary": "#3B82F6", // Compatibilidad
                "yellow-accent": "#F59E0B", // Compatibilidad
                "logo-primary": "#0052CC", // Logo Principal
                "logo-blue-200": "#DBEAFE", // Logo Secundario
            },

            fontFamily: {
                // === TIPOGRAFÍA PREMIUM ===
                sans: ["Inter", "system-ui", "sans-serif"], // Tipografía Principal
                headings: ["Poppins", "system-ui", "sans-serif"], // Títulos
                display: ["Poppins", "system-ui", "sans-serif"], // Display
                body: ["Inter", "system-ui", "sans-serif"], // Cuerpo
                mono: ["JetBrains Mono", "Menlo", "Monaco", "monospace"], // Monospace

                // === FUENTES ESPECÍFICAS ===
                inter: ["Inter", "system-ui", "sans-serif"],
                poppins: ["Poppins", "system-ui", "sans-serif"],
                jetbrains: ["JetBrains Mono", "Menlo", "Monaco", "monospace"],

                // === COMPATIBILIDAD (LEGACY) ===
                montserrat: ["Montserrat", "system-ui", "sans-serif"],
                "open-sans": ["Open Sans", "system-ui", "sans-serif"],
                alt: ["Inter", "system-ui", "sans-serif"],
            },

            fontSize: {
                // === ESCALA TIPOGRÁFICA PREMIUM ===
                xs: ["0.75rem", { lineHeight: "1rem" }], // 12px
                sm: ["0.875rem", { lineHeight: "1.25rem" }], // 14px
                base: ["1rem", { lineHeight: "1.5rem" }], // 16px
                lg: ["1.125rem", { lineHeight: "1.75rem" }], // 18px
                xl: ["1.25rem", { lineHeight: "1.75rem" }], // 20px
                "2xl": ["1.5rem", { lineHeight: "2rem" }], // 24px
                "3xl": ["1.875rem", { lineHeight: "2.25rem" }], // 30px
                "4xl": ["2.25rem", { lineHeight: "2.5rem" }], // 36px
                "5xl": ["3rem", { lineHeight: "3.375rem" }], // 48px
                "6xl": ["3.75rem", { lineHeight: "4rem" }], // 60px
                "7xl": ["4.5rem", { lineHeight: "4.5rem" }], // 72px
                "8xl": ["6rem", { lineHeight: "6rem" }], // 96px
                "9xl": ["8rem", { lineHeight: "8rem" }], // 128px
            },

            spacing: {
                // === SISTEMA DE ESPACIADO PREMIUM ===
                0.5: "0.125rem", // 2px
                1.5: "0.375rem", // 6px
                2.5: "0.625rem", // 10px
                3.5: "0.875rem", // 14px
                4.5: "1.125rem", // 18px
                5.5: "1.375rem", // 22px
                6.5: "1.625rem", // 26px
                7.5: "1.875rem", // 30px
                8.5: "2.125rem", // 34px
                9.5: "2.375rem", // 38px
                10.5: "2.625rem", // 42px
                11.5: "2.875rem", // 46px
                12.5: "3.125rem", // 50px
                15: "3.75rem", // 60px
                18: "4.5rem", // 72px
                22: "5.5rem", // 88px
                26: "6.5rem", // 104px
                30: "7.5rem", // 120px
                34: "8.5rem", // 136px
                38: "9.5rem", // 152px
                42: "10.5rem", // 168px
                46: "11.5rem", // 184px
                50: "12.5rem", // 200px
            },

            borderRadius: {
                // === RADIO DE ESQUINAS PREMIUM ===
                none: "0px",
                sm: "0.25rem", // 4px
                DEFAULT: "0.5rem", // 8px
                md: "0.75rem", // 12px
                lg: "1rem", // 16px
                xl: "1.25rem", // 20px
                "2xl": "1.5rem", // 24px
                "3xl": "1.75rem", // 28px
                "4xl": "2rem", // 32px
                full: "9999px",
            },

            boxShadow: {
                // === SOMBRAS PREMIUM ===
                xs: "0 1px 2px 0 rgba(0, 0, 0, 0.05)",
                sm: "0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
                DEFAULT:
                    "0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06)",
                md: "0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)",
                lg: "0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05)",
                xl: "0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04)",
                "2xl": "0 25px 50px -12px rgba(0, 0, 0, 0.25)",
                "3xl": "0 35px 60px -15px rgba(0, 0, 0, 0.3)",
                "4xl": "0 45px 80px -20px rgba(0, 0, 0, 0.4)",
                inner: "inset 0 2px 4px 0 rgba(0, 0, 0, 0.06)",
                none: "none",

                // === SOMBRAS ESPECÍFICAS ISUS ===
                primary: "0 4px 12px rgba(0, 82, 204, 0.3)",
                "primary-lg": "0 8px 24px rgba(0, 82, 204, 0.2)",
                accent: "0 4px 12px rgba(234, 88, 12, 0.3)",
                "accent-lg": "0 8px 24px rgba(234, 88, 12, 0.2)",
                success: "0 4px 12px rgba(5, 150, 105, 0.3)",
                error: "0 4px 12px rgba(220, 38, 38, 0.3)",
                glow: "0 0 20px rgba(0, 82, 204, 0.4)",
                "glow-accent": "0 0 20px rgba(234, 88, 12, 0.4)",
            },

            backdropBlur: {
                xs: "2px",
                sm: "4px",
                md: "8px",
                lg: "12px",
                xl: "16px",
                "2xl": "24px",
                "3xl": "40px",
            },

            keyframes: {
                // === ANIMACIONES PREMIUM ===
                "fade-in": {
                    "0%": { opacity: "0" },
                    "100%": { opacity: "1" },
                },
                "fade-out": {
                    "0%": { opacity: "1" },
                    "100%": { opacity: "0" },
                },
                "fade-in-down": {
                    "0%": { opacity: "0", transform: "translateY(-10px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                "fade-in-up": {
                    "0%": { opacity: "0", transform: "translateY(10px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                "fade-in-left": {
                    "0%": { opacity: "0", transform: "translateX(-10px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                "fade-in-right": {
                    "0%": { opacity: "0", transform: "translateX(10px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                "slide-in-left": {
                    "0%": { opacity: "0", transform: "translateX(-20px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                "slide-in-right": {
                    "0%": { opacity: "0", transform: "translateX(20px)" },
                    "100%": { opacity: "1", transform: "translateX(0)" },
                },
                "slide-in-up": {
                    "0%": { opacity: "0", transform: "translateY(20px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                "slide-in-down": {
                    "0%": { opacity: "0", transform: "translateY(-20px)" },
                    "100%": { opacity: "1", transform: "translateY(0)" },
                },
                "scale-in": {
                    "0%": { opacity: "0", transform: "scale(0.9)" },
                    "100%": { opacity: "1", transform: "scale(1)" },
                },
                "scale-out": {
                    "0%": { opacity: "1", transform: "scale(1)" },
                    "100%": { opacity: "0", transform: "scale(0.9)" },
                },
                "pop-in": {
                    "0%": { opacity: "0", transform: "scale(0.8)" },
                    "50%": { opacity: "1", transform: "scale(1.05)" },
                    "100%": { opacity: "1", transform: "scale(1)" },
                },
                "bounce-in": {
                    "0%": { opacity: "0", transform: "scale(0.3)" },
                    "50%": { opacity: "1", transform: "scale(1.1)" },
                    "70%": { transform: "scale(0.9)" },
                    "100%": { opacity: "1", transform: "scale(1)" },
                },
                "pulse-slow": {
                    "0%, 100%": { opacity: "1" },
                    "50%": { opacity: "0.7" },
                },
                "pulse-fast": {
                    "0%, 100%": { opacity: "1" },
                    "50%": { opacity: "0.5" },
                },
                wiggle: {
                    "0%, 100%": { transform: "rotate(-3deg)" },
                    "50%": { transform: "rotate(3deg)" },
                },
                float: {
                    "0%, 100%": { transform: "translateY(0px)" },
                    "50%": { transform: "translateY(-10px)" },
                },
                "gradient-x": {
                    "0%, 100%": { "background-position": "0% 50%" },
                    "50%": { "background-position": "100% 50%" },
                },
                "gradient-y": {
                    "0%, 100%": { "background-position": "50% 0%" },
                    "50%": { "background-position": "50% 100%" },
                },
                "gradient-xy": {
                    "0%, 100%": { "background-position": "0% 0%" },
                    "25%": { "background-position": "100% 0%" },
                    "50%": { "background-position": "100% 100%" },
                    "75%": { "background-position": "0% 100%" },
                },
                shimmer: {
                    "0%": { transform: "translateX(-100%)" },
                    "100%": { transform: "translateX(100%)" },
                },
                "spin-slow": {
                    "0%": { transform: "rotate(0deg)" },
                    "100%": { transform: "rotate(360deg)" },
                },
                "ping-slow": {
                    "0%": { transform: "scale(1)", opacity: "1" },
                    "75%, 100%": { transform: "scale(1.5)", opacity: "0" },
                },
            },

            animation: {
                // === ANIMACIONES APLICADAS ===
                "fade-in": "fade-in 0.5s ease-out forwards",
                "fade-out": "fade-out 0.5s ease-out forwards",
                "fade-in-down": "fade-in-down 0.6s ease-out forwards",
                "fade-in-up": "fade-in-up 0.6s ease-out forwards",
                "fade-in-left": "fade-in-left 0.6s ease-out forwards",
                "fade-in-right": "fade-in-right 0.6s ease-out forwards",
                "slide-in-left": "slide-in-left 0.6s ease-out forwards",
                "slide-in-right": "slide-in-right 0.6s ease-out forwards",
                "slide-in-up": "slide-in-up 0.6s ease-out forwards",
                "slide-in-down": "slide-in-down 0.6s ease-out forwards",
                "scale-in": "scale-in 0.3s ease-out forwards",
                "scale-out": "scale-out 0.3s ease-out forwards",
                "pop-in": "pop-in 0.7s ease-out forwards",
                "bounce-in": "bounce-in 0.8s ease-out forwards",
                "pulse-slow": "pulse-slow 2s infinite",
                "pulse-fast": "pulse-fast 1s infinite",
                wiggle: "wiggle 1s ease-in-out infinite",
                float: "float 3s ease-in-out infinite",
                "gradient-x": "gradient-x 3s ease infinite",
                "gradient-y": "gradient-y 3s ease infinite",
                "gradient-xy": "gradient-xy 3s ease infinite",
                shimmer: "shimmer 2s linear infinite",
                "spin-slow": "spin-slow 3s linear infinite",
                "ping-slow": "ping-slow 2s cubic-bezier(0, 0, 0.2, 1) infinite",
            },

            backgroundImage: {
                // === GRADIENTES PREMIUM ===
                "gradient-primary":
                    "linear-gradient(135deg, #0052CC 0%, #3B82F6 100%)",
                "gradient-secondary":
                    "linear-gradient(135deg, #3B82F6 0%, #60A5FA 100%)",
                "gradient-accent":
                    "linear-gradient(135deg, #F97316 0%, #FDBA74 100%)", // Gradiente actualizado
                "gradient-success":
                    "linear-gradient(135deg, #059669 0%, #10B981 100%)",
                "gradient-warning":
                    "linear-gradient(135deg, #F59E0B 0%, #FCD34D 100%)",
                "gradient-error":
                    "linear-gradient(135deg, #DC2626 0%, #EF4444 100%)",
                "gradient-innovation":
                    "linear-gradient(135deg, #7C3AED 0%, #8B5CF6 100%)",
                "gradient-dark":
                    "linear-gradient(135deg, #1F2937 0%, #374151 100%)",
                "gradient-light":
                    "linear-gradient(135deg, #F9FAFB 0%, #FFFFFF 100%)",
                "gradient-radial":
                    "radial-gradient(ellipse at center, var(--tw-gradient-stops))",
                "gradient-conic":
                    "conic-gradient(from 180deg at 50% 50%, var(--tw-gradient-stops))",
            },

            transitionTimingFunction: {
                // === CURVAS DE TRANSICIÓN PREMIUM ===
                "in-expo": "cubic-bezier(0.95, 0.05, 0.795, 0.035)",
                "out-expo": "cubic-bezier(0.19, 1, 0.22, 1)",
                "in-out-expo": "cubic-bezier(1, 0, 0, 1)",
                "in-circ": "cubic-bezier(0.6, 0.04, 0.98, 0.335)",
                "out-circ": "cubic-bezier(0.075, 0.82, 0.165, 1)",
                "in-out-circ": "cubic-bezier(0.785, 0.135, 0.15, 0.86)",
                "in-back": "cubic-bezier(0.6, -0.28, 0.735, 0.045)",
                "out-back": "cubic-bezier(0.175, 0.885, 0.32, 1.275)",
                "in-out-back": "cubic-bezier(0.68, -0.55, 0.265, 1.55)",
            },

            transitionDuration: {
                0: "0ms",
                50: "50ms",
                100: "100ms",
                200: "200ms",
                300: "300ms",
                400: "400ms",
                500: "500ms",
                600: "600ms",
                700: "700ms",
                800: "800ms",
                900: "900ms",
                1000: "1000ms",
                1500: "1500ms",
                2000: "2000ms",
            },

            zIndex: {
                // === CAPAS Z ORGANIZADAS ===
                0: "0",
                10: "10",
                20: "20",
                30: "30",
                40: "40",
                50: "50",
                auto: "auto",
                dropdown: "100",
                sticky: "200",
                fixed: "300",
                "modal-backdrop": "400",
                modal: "500",
                popover: "600",
                tooltip: "700",
                toast: "800",
                max: "9999",
            },

            screens: {
                // === BREAKPOINTS PREMIUM ===
                xs: "475px",
                sm: "640px",
                md: "768px",
                lg: "1024px",
                xl: "1280px",
                "2xl": "1536px",
                "3xl": "1920px",
            },
        },
    },
    plugins: [
        forms,
        // Plugin personalizado para utilidades adicionales
        function ({ addUtilities, theme }) {
            const newUtilities = {
                // === UTILIDADES PERSONALIZADAS ===
                ".text-gradient": {
                    background: theme("backgroundImage.gradient-primary"),
                    "-webkit-background-clip": "text",
                    "-webkit-text-fill-color": "transparent",
                    "background-clip": "text",
                },
                ".text-gradient-accent": {
                    background: theme("backgroundImage.gradient-accent"),
                    "-webkit-background-clip": "text",
                    "-webkit-text-fill-color": "transparent",
                    "background-clip": "text",
                },
                ".backdrop-blur-glass": {
                    "backdrop-filter": "blur(16px) saturate(180%)",
                    "-webkit-backdrop-filter": "blur(16px) saturate(180%)",
                },
                ".border-gradient": {
                    border: "1px solid transparent",
                    background: `linear-gradient(white, white) padding-box, ${theme(
                        "backgroundImage.gradient-primary"
                    )} border-box`,
                },
                ".scrollbar-hide": {
                    "-ms-overflow-style": "none",
                    "scrollbar-width": "none",
                    "&::-webkit-scrollbar": {
                        display: "none",
                    },
                },
                ".scrollbar-thin": {
                    "scrollbar-width": "thin",
                    "scrollbar-color": `${theme("colors.gray-silver")} ${theme(
                        "colors.gray-light"
                    )}`,
                },
            };

            addUtilities(newUtilities);
        },
    ],
};
