@php
    $path = parse_url($_SERVER['REQUEST_URI'] ?? '', PHP_URL_PATH);
    $pageSegments = explode('/', trim($path, '/'));
    $page =$pageSegments[0] ?? '';
@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? config('app.name') }}</title>

    {{-- =========================================================
        THEME INITIALIZATION (Runs immediately; prevents FOUC)
    ========================================================== --}}
    <script>
        (function () {
            const validThemes = ["light", "dark", "dim", "cyberpunk"];
            let savedTheme = localStorage.getItem("theme") || "light";

            if (!validThemes.includes(savedTheme)) {
                savedTheme = "light";
            }

            document.documentElement.classList.remove(...validThemes);
            document.documentElement.classList.add(savedTheme);
        })();
    </script>

    {{-- =========================================================
        FONT AWESOME
    ========================================================== --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >
    <!-- CDN option -->
    <link href="{{asset("summernote/summernote-lite.min.css")}}" rel="stylesheet">
    {{-- =========================================================
        VITE ASSETS
    ========================================================== --}}
    @vite([
        'resources/css/app.css',
        'resources/css/custom.css',
        'resources/js/app.js',
        'resources/js/summernote.min.js',
    ])

    @livewireStyles



    {{-- =========================================================
        TOOLTIP CSS
    ========================================================== --}}
    <style>
        #sidebarFloatingTooltip {
            position: fixed;
            z-index: 99999;
            padding: 8px 12px;
            border-radius: 6px;
            background: var(--theme-card);
            color: var(--theme-heading);
            border: 1px solid var(--theme-border);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
            font-size: 13px;
            white-space: nowrap;
            pointer-events: none;
            opacity: 0;
            visibility: hidden;
            transition: opacity 150ms ease, transform 150ms ease;
        }

        #sidebarFloatingTooltip.show {
            opacity: 1;
            visibility: visible;
        }
    </style>
</head>

<body class="bg-background text-text font-sans overflow-hidden transition-colors duration-200">

    {{-- =========================================================
        MAIN APPLICATION WRAPPER
    ========================================================== --}}
    <div class="flex h-screen overflow-hidden">

        {{-- Mobile Sidebar Overlay --}}
        <div
            id="sidebarOverlay"
            onclick="closeMobileSidebar()"
            class="fixed inset-0 z-40 bg-black/40 hidden lg:hidden"
        ></div>

        {{-- Sidebar --}}
        @include("layouts.sidebar", ['page' => $page])

        {{-- Main Content Column --}}
        <div id="mainContent" class="flex-1 flex flex-col min-w-0">

            {{-- Header --}}
            @include("layouts.header")

            {{-- Content View --}}
            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 transition-colors duration-200">
                {{ $slot }}
            </main>

        </div>

    </div>

    {{-- Floating Sidebar Tooltip --}}
    <div id="sidebarFloatingTooltip"></div>

    @livewireScripts

    {{-- =========================================================
        APPLICATION JAVASCRIPT
    ========================================================== --}}
    <script>
        /*
        |--------------------------------------------------------------------------
        | CONSTANTS & MAPPINGS
        |--------------------------------------------------------------------------
        */
        const themes = ["light", "dark", "dim", "cyberpunk"];

        const themeIcons = {
            light: "fas fa-sun",
            dark: "fas fa-moon",
            dim: "fas fa-cloud-moon",
            cyberpunk: "fas fa-bolt"
        };

        let sidebar = null;
        let overlay = null;
        let tooltip = null;

        /*
        |--------------------------------------------------------------------------
        | THEME ENGINE
        |--------------------------------------------------------------------------
        */
        function setTheme(themeName) {
            const html = document.documentElement;

            if (!themes.includes(themeName)) {
                themeName = "light";
            }

            html.classList.remove(...themes);
            html.classList.add(themeName);
            localStorage.setItem("theme", themeName);

            updateButtonVisuals(themeName);
        }

        function cycleThemes() {
            const currentTheme = localStorage.getItem("theme") || "light";
            let currentIndex = themes.indexOf(currentTheme);

            if (currentIndex === -1) {
                currentIndex = 0;
            }

            const nextIndex = (currentIndex + 1) % themes.length;
            setTheme(themes[nextIndex]);
        }

        function updateButtonVisuals(themeName) {
            const icon = document.getElementById("theme-icon");
            if (!icon) return;

            icon.className = themeIcons[themeName] || themeIcons.light;
        }

        /*
        |--------------------------------------------------------------------------
        | SIDEBAR CONTROLLER
        |--------------------------------------------------------------------------
        */
        function toggleSidebar() {
            if (!sidebar) return;

            // Mobile toggle
            if (window.innerWidth < 1024) {
                const hidden = sidebar.classList.contains("-translate-x-full");
                if (hidden) {
                    sidebar.classList.remove("-translate-x-full");
                    if (overlay) overlay.classList.remove("hidden");
                } else {
                    closeMobileSidebar();
                }
                return;
            }

            // Desktop toggle
            const isCollapsed = sidebar.getAttribute("data-collapsed") === "true";
            if (!isCollapsed) {
                collapseSidebar();
            } else {
                expandSidebar();
            }
        }

        function collapseSidebar() {
            if (!sidebar) return;

            sidebar.style.width = "5rem";
            sidebar.setAttribute("data-collapsed", "true");

            document.querySelectorAll(".sidebar-text").forEach(el => el.classList.add("hidden"));
            document.querySelectorAll(".logo").forEach(el => {
                el.classList.remove("hidden");
                el.classList.add("flex");
            });
            document.querySelectorAll(".footer-text").forEach(el => {
                el.classList.remove("hidden");
                el.classList.add("flex");
            });

            localStorage.setItem("sidebarCollapsed", "true");
        }

        function expandSidebar() {
            if (!sidebar) return;

            sidebar.style.width = "16rem";
            sidebar.setAttribute("data-collapsed", "false");
            hideSidebarTooltip();

            document.querySelectorAll(".sidebar-text").forEach(el => el.classList.remove("hidden"));
            document.querySelectorAll(".logo").forEach(el => {
                el.classList.add("hidden");
                el.classList.remove("flex");
            });
            document.querySelectorAll(".footer-text").forEach(el => {
                el.classList.remove("flex");
                el.classList.add("hidden");
            });

            localStorage.setItem("sidebarCollapsed", "false");
        }

        function closeMobileSidebar() {
            if (!sidebar) return;

            sidebar.classList.add("-translate-x-full");
            if (overlay) overlay.classList.add("hidden");
            hideSidebarTooltip();
        }

        /*
        |--------------------------------------------------------------------------
        | FLOATING TOOLTIPS
        |--------------------------------------------------------------------------
        */
        function initializeSidebarTooltips() {
            if (!tooltip) return;

            const items = document.querySelectorAll(".sidebar-item[data-tooltip]");
            items.forEach(item => {
                item.onmouseenter = () => showSidebarTooltip(item);
                item.onmouseleave = () => hideSidebarTooltip();
            });
        }

        function showSidebarTooltip(item) {
            if (!sidebar || !tooltip || window.innerWidth < 1024) return;
            if (sidebar.getAttribute("data-collapsed") !== "true") return;

            const text = item.dataset.tooltip;
            if (!text) return;

            const rect = item.getBoundingClientRect();
            tooltip.textContent = text;
            tooltip.classList.add("show");

            tooltip.style.left = `${rect.right + 10}px`;
            tooltip.style.top = `${rect.top + rect.height / 2}px`;
            tooltip.style.transform = "translateY(-50%)";
        }

        function hideSidebarTooltip() {
            if (!tooltip) return;
            tooltip.classList.remove("show");
        }

        /*
        |--------------------------------------------------------------------------
        | PROFILE DROPDOWN
        |--------------------------------------------------------------------------
        */
        function toggleProfileDropdown(event) {
            if (event) event.stopPropagation();

            const dropdown = document.getElementById("profileDropdown");
            if (dropdown) dropdown.classList.toggle("hidden");
        }

        document.addEventListener("click", function (event) {
            const dropdown = document.getElementById("profileDropdown");
            if (dropdown && !event.target.closest(".profile-wrapper")) {
                dropdown.classList.add("hidden");
            }
        });

        /*
        |--------------------------------------------------------------------------
        | APP INITIALIZER
        |--------------------------------------------------------------------------
        */
        function initializeApp() {
            sidebar = document.getElementById("sidebar");
            overlay = document.getElementById("sidebarOverlay");
            tooltip = document.getElementById("sidebarFloatingTooltip");

            const savedTheme = localStorage.getItem("theme") || "light";
            setTheme(savedTheme);

            if (sidebar) {
                if (window.innerWidth < 1024) {
                    sidebar.classList.add("-translate-x-full");
                } else {
                    sidebar.classList.remove("-translate-x-full");
                    const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
                    if (isCollapsed) {
                        collapseSidebar();
                    } else {
                        expandSidebar();
                    }
                }
            }

            initializeSidebarTooltips();
        }

        document.addEventListener("DOMContentLoaded", initializeApp);
        document.addEventListener("livewire:navigated", initializeApp);

        window.addEventListener("resize", function () {
            if (!sidebar) return;

            hideSidebarTooltip();

            if (window.innerWidth >= 1024) {
                if (overlay) overlay.classList.add("hidden");
                sidebar.classList.remove("-translate-x-full");

                const isCollapsed = localStorage.getItem("sidebarCollapsed") === "true";
                if (isCollapsed) {
                    collapseSidebar();
                } else {
                    expandSidebar();
                }
            } else {
                sidebar.classList.add("-translate-x-full");
            }
        });
    </script>
    <x-toaster-hub />
</body>
</html>
