window.fnToggle = function (event, data) {
    // 1. DO NOT call event.stopPropagation() here; let the document know a click happened
    const dropdownId = typeof data === "object" ? data.id : data;
    const dropdown = document.getElementById(dropdownId);

    if (!dropdown) return;

    // 2. Hide all other dropdowns
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
        if (menu !== dropdown) {
            menu.classList.add("hidden");
        }
    });

    // 3. Toggle current menu
    dropdown.classList.toggle("hidden");
};

// Global click listener for closing outside clicks
document.addEventListener("click", function (event) {
    // If the click happened on a toggle button or inside a menu, let fnToggle handle it
    if (
        event.target.closest(".dropdown-toggle") ||
        event.target.closest(".dropdown-menu")
    ) {
        return;
    }

    // Otherwise, close every open menu
    document.querySelectorAll(".dropdown-menu").forEach((menu) => {
        menu.classList.add("hidden");
    });
});
