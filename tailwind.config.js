import colors from "tailwindcss/colors";
import forms from "@tailwindcss/forms";
import typography from "@tailwindcss/typography";

export default {
    content: [
        "./resources/**/*.blade.php",
        "./vendor/filament/**/*.blade.php"
    ],
    darkMode: "class",

    theme: {
        screens: {
            'sm': '640px',
            // => @media (min-width: 640px) { ... }
            'md': '768px',
            // => @media (min-width: 768px) { ... }

            'lg': '1024px',
            // => @media (min-width: 1024px) { ... }

            'xl': '1280px',
            // => @media (min-width: 1280px) { ... }
            '2xl': '1536px',
            // => @media (min-width: 1536px) { ... }
        },

        extend: {
            colors: {
                danger: colors.rose,
                primary: colors.teal,
                success: colors.green,
                warning: colors.yellow,
                secondary: colors.sky,
            },
        },
    },
    plugins: [forms, typography],
};
