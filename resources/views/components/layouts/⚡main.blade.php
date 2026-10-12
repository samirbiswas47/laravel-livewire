<?php

use Livewire\Component;

new class extends Component
{
    //
};
?>

<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        {{ $title ?? config('app.name') }}
    </title>


    {{-- =========================================================
        THEME INITIALIZATION
    ========================================================== --}}

    <script>

        (function () {

            const themes = [
                "light",
                "dark",
                "dim",
                "cyberpunk"
            ];

            let savedTheme =
                localStorage.getItem("theme") || "light";

            if (!themes.includes(savedTheme)) {
                savedTheme = "light";
            }

            document.addEventListener("DOMContentLoaded", function () {
                const savedTheme =
                    localStorage.getItem("theme") || "light";

                setTheme(savedTheme);
            });

        })();

    </script>


    {{-- =========================================================
        TAILWIND CSS v4
    ========================================================== --}}

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


    {{-- =========================================================
        FONT AWESOME
    ========================================================== --}}

    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
    >


    {{-- =========================================================
        VITE
    ========================================================== --}}

    @vite([
        'resources/css/app.css',
        'resources/css/custom.css',
        'resources/js/app.js'
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

            box-shadow:
                0 10px 25px
                rgba(0, 0, 0, 0.15);

            font-size: 13px;

            white-space: nowrap;

            pointer-events: none;

            opacity: 0;

            visibility: hidden;

            transition:
                opacity 150ms ease,
                transform 150ms ease;

        }


        #sidebarFloatingTooltip.show {

            opacity: 1;

            visibility: visible;

        }

    </style>

</head>


<body
    class="
        bg-background
        text-text
        font-sans
        overflow-hidden
        transition-colors
        duration-200
    "
>


    {{-- =========================================================
        LIVEWIRE
    ========================================================== --}}

    @livewireScripts


    {{-- =========================================================
        MAIN APPLICATION
    ========================================================== --}}

    <div class="flex h-screen overflow-hidden">


        {{-- =====================================================
            MOBILE SIDEBAR OVERLAY
        ====================================================== --}}

        <div
            id="sidebarOverlay"

            onclick="closeMobileSidebar()"

            class="
                fixed
                inset-0
                z-40
                bg-black/40
                hidden
                lg:hidden
            "
        >
        </div>


        {{-- =====================================================
            SIDEBAR
        ====================================================== --}}

        @include("layouts.sidebar")


        {{-- =====================================================
            MAIN CONTENT
        ====================================================== --}}

        <div
            id="mainContent"

            class="
                flex-1
                flex
                flex-col
                min-w-0
            "
        >


            {{-- =================================================
                HEADER
            ================================================== --}}

            @include("layouts.header")


            {{-- =================================================
                CONTENT
            ================================================== --}}

            <main
                class="
                    flex-1
                    overflow-x-hidden
                    overflow-y-auto
                    p-4
                    md:p-6

                    transition-colors
                    duration-200
                "
            >

                {{ $slot }}

            </main>

        </div>

    </div>


    {{-- =========================================================
        FLOATING SIDEBAR TOOLTIP
    ========================================================== --}}

    <div id="sidebarFloatingTooltip"></div>


    {{-- =========================================================
        APPLICATION JAVASCRIPT
    ========================================================== --}}

    <script>

        /*
        |--------------------------------------------------------------------------
        | THEME ENGINE
        |--------------------------------------------------------------------------
        */

        const themes = [
            "light",
            "dark",
            "dim",
            "cyberpunk"
        ];


        const themeIcons = {

            light:
                "fas fa-sun",

            dark:
                "fas fa-moon",

            dim:
                "fas fa-cloud-moon",

            cyberpunk:
                "fas fa-bolt"

        };


        /*
        |--------------------------------------------------------------------------
        | SET THEME
        |--------------------------------------------------------------------------
        */

        function setTheme(themeName) {

            const html =
                document.documentElement;


            /*
            |--------------------------------------------------------------------------
            | Validate theme
            |--------------------------------------------------------------------------
            */

            if (!themes.includes(themeName)) {

                themeName = "light";

            }


            /*
            |--------------------------------------------------------------------------
            | Remove existing themes
            |--------------------------------------------------------------------------
            */

            html.classList.remove(
                ...themes
            );


            /*
            |--------------------------------------------------------------------------
            | Add selected theme
            |--------------------------------------------------------------------------
            */

            html.classList.add(
                themeName
            );


            /*
            |--------------------------------------------------------------------------
            | Save theme
            |--------------------------------------------------------------------------
            */

            localStorage.setItem(
                "theme",
                themeName
            );


            /*
            |--------------------------------------------------------------------------
            | Update button icon
            |--------------------------------------------------------------------------
            */

            updateButtonVisuals(
                themeName
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CYCLE THEMES
        |--------------------------------------------------------------------------
        */

        function cycleThemes() {

            const currentTheme =
                localStorage.getItem("theme")
                || "light";


            let currentIndex =
                themes.indexOf(
                    currentTheme
                );


            /*
            |--------------------------------------------------------------------------
            | If invalid theme
            |--------------------------------------------------------------------------
            */

            if (currentIndex === -1) {

                currentIndex = 0;

            }


            /*
            |--------------------------------------------------------------------------
            | Next theme
            |--------------------------------------------------------------------------
            */

            const nextIndex =
                (currentIndex + 1)
                % themes.length;


            const nextTheme =
                themes[nextIndex];


            /*
            |--------------------------------------------------------------------------
            | Apply
            |--------------------------------------------------------------------------
            */

            setTheme(
                nextTheme
            );

        }


        /*
        |--------------------------------------------------------------------------
        | UPDATE THEME BUTTON
        |--------------------------------------------------------------------------
        */

        function updateButtonVisuals(themeName) {

            const icon =
                document.getElementById(
                    "theme-icon"
                );


            if (!icon) {

                return;

            }


            icon.className =
                themeIcons[themeName]
                || themeIcons.light;

        }


        /*
        |--------------------------------------------------------------------------
        | INITIALIZE THEME
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            "DOMContentLoaded",
            function () {

                const savedTheme =
                    localStorage.getItem(
                        "theme"
                    )
                    || "light";


                setTheme(
                    savedTheme
                );

            }
        );


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR ELEMENTS
        |--------------------------------------------------------------------------
        */

        const sidebar =
            document.getElementById(
                "sidebar"
            );


        const overlay =
            document.getElementById(
                "sidebarOverlay"
            );


        const tooltip =
            document.getElementById(
                "sidebarFloatingTooltip"
            );


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR TOGGLE
        |--------------------------------------------------------------------------
        */

        function toggleSidebar() {

            if (!sidebar) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | MOBILE
            |--------------------------------------------------------------------------
            */

            if (window.innerWidth < 1024) {

                const hidden =
                    sidebar.classList.contains(
                        "-translate-x-full"
                    );


                if (hidden) {

                    sidebar.classList.remove(
                        "-translate-x-full"
                    );


                    if (overlay) {

                        overlay.classList.remove(
                            "hidden"
                        );

                    }

                }
                else {

                    closeMobileSidebar();

                }


                return;

            }


            /*
            |--------------------------------------------------------------------------
            | DESKTOP
            |--------------------------------------------------------------------------
            */

            const isCollapsed =
                sidebar.getAttribute(
                    "data-collapsed"
                ) === "true";


            sidebar.setAttribute(
                "data-collapsed",
                String(!isCollapsed)
            );


            if (!isCollapsed) {

                collapseSidebar();

            }
            else {

                expandSidebar();

            }

        }

        function toggleSidebarMenu(menuName) {

    const menu = document.getElementById(
        menuName + "-menu"
    );

    const arrow = document.getElementById(
        menuName + "-arrow"
    );

    if (!menu) {
        return;
    }

    menu.classList.toggle("hidden");

    if (arrow) {
        arrow.classList.toggle("rotate-180");
    }
}
        /*
        |--------------------------------------------------------------------------
        | COLLAPSE SIDEBAR
        |--------------------------------------------------------------------------
        */

        function collapseSidebar() {

            if (!sidebar) {

                return;

            }


            sidebar.style.width =
                "5rem";


            sidebar.setAttribute(
                "data-collapsed",
                "true"
            );


            document
                .querySelectorAll(
                    ".sidebar-text"
                )
                .forEach(
                    element => {

                        element.classList.add(
                            "hidden"
                        );

                    }
                );


            document
                .querySelectorAll(
                    ".logo"
                )
                .forEach(
                    element => {

                        element.classList.remove(
                            "hidden"
                        );

                        element.classList.add(
                            "flex"
                        );

                    }
                );


            document
                .querySelectorAll(
                    ".footer-text"
                )
                .forEach(
                    element => {

                        element.classList.remove(
                            "hidden"
                        );

                        element.classList.add(
                            "flex"
                        );

                    }
                );


            localStorage.setItem(
                "sidebarCollapsed",
                "true"
            );

        }


        /*
        |--------------------------------------------------------------------------
        | EXPAND SIDEBAR
        |--------------------------------------------------------------------------
        */

        function expandSidebar() {

            if (!sidebar) {

                return;

            }


            sidebar.style.width =
                "16rem";


            sidebar.setAttribute(
                "data-collapsed",
                "false"
            );


            hideSidebarTooltip();


            document
                .querySelectorAll(
                    ".sidebar-text"
                )
                .forEach(
                    element => {

                        element.classList.remove(
                            "hidden"
                        );

                    }
                );


            document
                .querySelectorAll(
                    ".logo"
                )
                .forEach(
                    element => {

                        element.classList.add(
                            "hidden"
                        );

                        element.classList.remove(
                            "flex"
                        );

                    }
                );


            document
                .querySelectorAll(
                    ".footer-text"
                )
                .forEach(
                    element => {

                        element.classList.remove(
                            "flex"
                        );

                        element.classList.add(
                            "hidden"
                        );

                    }
                );
            const childMenus = document.querySelectorAll(
                ".sidebar-child-menu"
            );

            childMenus.forEach(menu => {
                menu.classList.add("hidden");
            });

            localStorage.setItem(
                "sidebarCollapsed",
                "false"
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE MOBILE SIDEBAR
        |--------------------------------------------------------------------------
        */

        function closeMobileSidebar() {

            if (!sidebar) {

                return;

            }


            sidebar.classList.add(
                "-translate-x-full"
            );


            if (overlay) {

                overlay.classList.add(
                    "hidden"
                );

            }


            hideSidebarTooltip();

        }


        /*
        |--------------------------------------------------------------------------
        | SIDEBAR TOOLTIPS
        |--------------------------------------------------------------------------
        */

        function initializeSidebarTooltips() {

            if (!tooltip) {

                return;

            }


            const items =
                document.querySelectorAll(
                    ".sidebar-item[data-tooltip]"
                );


            items.forEach(
                item => {

                    item.addEventListener(
                        "mouseenter",
                        function () {

                            showSidebarTooltip(
                                item
                            );

                        }
                    );


                    item.addEventListener(
                        "mouseleave",
                        function () {

                            hideSidebarTooltip();

                        }
                    );

                }
            );

        }


        /*
        |--------------------------------------------------------------------------
        | SHOW TOOLTIP
        |--------------------------------------------------------------------------
        */

        function showSidebarTooltip(item) {

            if (!sidebar || !tooltip) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Desktop only
            |--------------------------------------------------------------------------
            */

            if (window.innerWidth < 1024) {

                return;

            }


            /*
            |--------------------------------------------------------------------------
            | Collapsed only
            |--------------------------------------------------------------------------
            */

            if (
                sidebar.dataset.collapsed
                !== "true"
            ) {

                return;

            }


            const text =
                item.dataset.tooltip;


            if (!text) {

                return;

            }


            const rect =
                item.getBoundingClientRect();


            tooltip.textContent =
                text;


            tooltip.classList.add(
                "show"
            );


            const left =
                rect.right + 10;


            const top =
                rect.top
                + (rect.height / 2);


            tooltip.style.left =
                `${left}px`;


            tooltip.style.top =
                `${top}px`;


            tooltip.style.transform =
                "translateY(-50%)";

        }


        /*
        |--------------------------------------------------------------------------
        | HIDE TOOLTIP
        |--------------------------------------------------------------------------
        */

        function hideSidebarTooltip() {

            if (!tooltip) {

                return;

            }


            tooltip.classList.remove(
                "show"
            );

        }


        /*
        |--------------------------------------------------------------------------
        | PROFILE DROPDOWN
        |--------------------------------------------------------------------------
        */

        function toggleProfileDropdown(event) {

            if (event) {

                event.stopPropagation();

            }


            const dropdown =
                document.getElementById(
                    "profileDropdown"
                );


            if (!dropdown) {

                return;

            }


            dropdown.classList.toggle(
                "hidden"
            );

        }


        /*
        |--------------------------------------------------------------------------
        | CLOSE PROFILE DROPDOWN
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            "click",
            function (event) {

                const dropdown =
                    document.getElementById(
                        "profileDropdown"
                    );


                if (
                    dropdown &&
                    !event.target.closest(
                        ".profile-wrapper"
                    )
                ) {

                    dropdown.classList.add(
                        "hidden"
                    );

                }

            }
        );


        /*
        |--------------------------------------------------------------------------
        | INITIALIZE SIDEBAR
        |--------------------------------------------------------------------------
        */

        document.addEventListener(
            "DOMContentLoaded",
            function () {

                if (!sidebar) {

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Mobile
                |--------------------------------------------------------------------------
                */

                if (
                    window.innerWidth < 1024
                ) {

                    sidebar.classList.add(
                        "-translate-x-full"
                    );

                    return;

                }


                /*
                |--------------------------------------------------------------------------
                | Saved sidebar state
                |--------------------------------------------------------------------------
                */

                const collapsed =
                    localStorage.getItem(
                        "sidebarCollapsed"
                    ) === "true";


                if (collapsed) {

                    collapseSidebar();

                }
                else {

                    expandSidebar();

                }


                initializeSidebarTooltips();

            }
        );


        /*
        |--------------------------------------------------------------------------
        | WINDOW RESIZE
        |--------------------------------------------------------------------------
        */

        window.addEventListener(
            "resize",
            function () {

                if (!sidebar) {

                    return;

                }


                hideSidebarTooltip();


                if (
                    window.innerWidth >= 1024
                ) {

                    if (overlay) {

                        overlay.classList.add(
                            "hidden"
                        );

                    }


                    sidebar.classList.remove(
                        "-translate-x-full"
                    );


                    const collapsed =
                        localStorage.getItem(
                            "sidebarCollapsed"
                        ) === "true";


                    if (collapsed) {

                        collapseSidebar();

                    }
                    else {

                        expandSidebar();

                    }

                }
                else {

                    sidebar.classList.add(
                        "-translate-x-full"
                    );

                }

            }
        );

    </script>




</body>

</html>
