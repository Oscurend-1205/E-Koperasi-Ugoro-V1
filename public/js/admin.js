// Theme Initialization Script
(function () {
    const savedTheme =
        localStorage.getItem("admin-theme") ||
        document.cookie
            .split("; ")
            .find((row) => row.startsWith("admin-theme="))
            ?.split("=")[1];
    const prefersDark = window.matchMedia(
        "(prefers-color-scheme: dark)",
    ).matches;

    if (savedTheme === "dark" || (!savedTheme && prefersDark)) {
        document.documentElement.setAttribute("data-theme", "dark");
    } else {
        document.documentElement.setAttribute("data-theme", "light");
    }
})();

function toggleTheme() {
    const currentTheme = document.documentElement.getAttribute("data-theme");
    const newTheme = currentTheme === "dark" ? "light" : "dark";

    // Apply to document
    document.documentElement.setAttribute("data-theme", newTheme);

    // Persist in localStorage
    localStorage.setItem("admin-theme", newTheme);

    // Persist in Cookie (for server-side initial render)
    document.cookie =
        "admin-theme=" + newTheme + "; path=/; max-age=31536000; SameSite=Lax";

    // Custom event so other components (like settings toggle or charts) can react
    window.dispatchEvent(
        new CustomEvent("themeChanged", { detail: { theme: newTheme } }),
    );

    console.log("Theme changed to:", newTheme);
}
