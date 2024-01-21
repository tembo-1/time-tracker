/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    darkMode: "class",
    theme: {
        extend: {
            backgroundImage: {
              'malachite-tech-pattern': "url('/img/image-background.jpg')"
            },
            colors: {
                "main-green": {
                    DEFAULT: "#079871",
                    700: "#05775b",
                },
                "main-light-green": "#2CE8A0",
                gray: "#888888",
                dark: "#333333",
                "light-gray": "#F3F3F3",
                error: "#B81212",
            },
            spacing: {
                5: "0.313rem",
                10: "0.625rem",
                15: "0.938rem",
                20: "1.25rem",
                30: "1.875rem",
                40: "2.5rem",
                50: "3.125rem",
                60: "3.75rem",
                70: "4.375rem",
                80: "5rem",
                90: "5.625rem",
                100: "6.25rem",
            },
            borderRadius: {
                5: "0.313rem",
            },
            borderWidth: {
                3: "3px",
                5: "5px"
            },
            fontSize: {
                xs: ["0.75rem", "0.938rem"],
                sm: ["0.875rem", "1.125rem"],
                base: ["1rem", "1.25rem"],
                lg: ["1.125rem", "1.5rem"],
                xl: ["1.25rem", "1.563rem"],
                "4xl": ["2.5rem", "3.125rem"],
            },
            boxShadow: {
                DEFAULT: "0 1px 2px 0 rgba(0, 0, 0, 0.25)",
                lg: "0 5px 10px 0px rgba(0, 0, 0, 0.25)",
            },
            screens: {
                sm: "480px",
                md: "768px",
                lg: "1024px",
                xl: "1280px",
                "2xl": "1440px",
            },
            container: {
                center: true,
            },
            fontFamily: {
                'inter': ["Inter", "sans-serif"],
            }
        },
    },
    plugins: [require("flowbite/plugin"), require("tw-elements/dist/plugin.cjs")],
};
