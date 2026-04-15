// Tailwind Config
if (typeof tailwind !== 'undefined') {
    tailwind.config = {
        darkMode: "class",
        theme: {
            extend: {
                colors: {
                    "primary": "#13ec5b",
                    "secondary": "#f97316",
                    "background-light": "#f1f5f9",
                    "background-dark": "#020617",
                },
                fontSize: {
                    'xs': ['0.65rem', '1rem'],
                    'sm': ['0.75rem', '1.125rem'],
                    'base': ['0.85rem', '1.25rem'],
                    'lg': ['1rem', '1.5rem'],
                    'xl': ['1.125rem', '1.75rem'],
                    '2xl': ['1.25rem', '1.75rem'],
                    '3xl': ['1.5rem', '2rem'],
                },
                fontFamily: {
                    "sans": ["Plus Jakarta Sans", "Inter", "sans-serif"],
                    "display": ["Inter", "sans-serif"]
                },
                borderRadius: {
                    "DEFAULT": "0.5rem",
                    "lg": "1rem",
                    "xl": "1.5rem",
                    "full": "9999px"
                },
            },
        },
    };
}

// Initialize Theme
(function() {
    const savedTheme = localStorage.getItem('ugoro_user_theme');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }
})();

function toggleUserTheme() {
    const htmlElement = document.documentElement;
    htmlElement.classList.toggle('dark');
    if (htmlElement.classList.contains('dark')) {
        localStorage.setItem('ugoro_user_theme', 'dark');
    } else {
        localStorage.setItem('ugoro_user_theme', 'light');
    }
}
