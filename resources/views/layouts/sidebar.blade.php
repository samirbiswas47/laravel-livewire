@php
    $currentPage = $page ?? null;
    $isAdminActive = in_array($currentPage, ['user', 'role', 'permission']) || request()->is('user*', 'role*', 'permission*');
@endphp

<aside
    id="sidebar"
    data-collapsed="false"
    class="
        fixed
        lg:static
        inset-y-0
        left-0
        z-50
        h-screen
        w-64
        bg-sidebar-bg
        text-sidebar-text
        flex
        flex-col
        transform
        -translate-x-full
        lg:translate-x-0
        overflow-hidden
        lg:overflow-visible
        transition-all
        duration-200
        border-r
        border-gray-700
    "
>

    {{-- =========================================================
         HEADER / LOGO
    ========================================================== --}}
    <div
        class="
            h-[67px]
            shrink-0
            p-4
            border-b
            border-gray-700
            flex
            items-center
            justify-between
            text-xl
            xl:text-2xl
            font-bold
        "
    >
        {{-- COLLAPSED LOGO --}}
        <div
            class="
                logo
                hidden
                h-10
                w-10
                shrink-0
                rounded-full
                bg-indigo-500
                text-white
                items-center
                justify-center
                font-semibold
                uppercase
            "
        >
            I
        </div>

        {{-- FULL LOGO --}}
        <span class="sidebar-text whitespace-nowrap">
            INVENTORY
        </span>

        {{-- MOBILE CLOSE --}}
        <button
            type="button"
            onclick="closeMobileSidebar()"
            class="
                lg:hidden
                w-7
                h-7
                shrink-0
                rounded-full
                bg-white
                text-black
                flex
                items-center
                justify-center
                text-sm
            "
        >
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    {{-- =========================================================
         NAVIGATION
    ========================================================== --}}
    <nav
        class="
            flex-1
            p-4
            space-y-2
            overflow-y-auto
            overflow-x-visible
        "
    >
        {{-- DASHBOARD --}}
        <a
            href="/dashboard"
            wire:navigate
            data-tooltip="Dashboard"
            class="
                sidebar-item
                flex
                items-center
                gap-3
                px-3
                py-3
                rounded-lg
                transition
                duration-200
                {{ request()->is('dashboard*') || $currentPage === 'dashboard'
                    ? 'bg-surface text-success'
                    : 'text-slate-300 hover:bg-sidebar-hover hover:text-white' }}
            "
        >
            <i class="fa-solid fa-house min-w-[20px] text-center"></i>
            <span class="sidebar-text whitespace-nowrap">
                Dashboard
            </span>
        </a>

        {{-- ADMINISTRATIONS (DROPDOWN GROUP) --}}
        <div
            class="relative sidebar-group"
            x-data="{ open: {{ $isAdminActive ? 'true' : 'false' }} }"
        >
            {{-- PARENT BUTTON --}}
            <button
                type="button"
                @click="open = !open"
                data-tooltip="Administrations"
                class="
                    sidebar-item
                    w-full
                    flex
                    items-center
                    gap-3
                    px-3
                    py-3
                    rounded-lg
                    hover:bg-sidebar-hover
                    hover:text-white
                    transition
                    duration-200
                    text-left

                "
            >
                <i class="fa-solid fa-book min-w-[20px] text-center"></i>

                <span class="sidebar-text whitespace-nowrap flex-1">
                    Administrations
                </span>

                {{-- Arrow: rotates via Alpine --}}
                <i
                    class="
                        sidebar-text
                        fa-solid
                        fa-chevron-down
                        text-xs
                        transition-transform
                        duration-200
                    "
                    :class="open ? 'rotate-180' : ''"
                ></i>
            </button>

            {{-- EXPANDED INLINE SUBMENU --}}
            <div
                id="administrations-menu"
                :class="{ 'hidden': !open }"
                class="
                    sidebar-child-menu
                    ml-6
                    mt-1
                    space-y-1
                    pl-2
                    {{ $isAdminActive ? '' : 'hidden' }}
                "
            >
                {{-- USERS --}}
                <a
                    href="/user"
                    wire:navigate
                    data-tooltip="Users"
                    class="
                        sidebar-item
                        sidebar-child-item
                        flex
                        items-center
                        gap-3
                        px-3
                        py-2
                        rounded-lg
                        text-sm
                        transition
                        duration-200
                        {{ request()->is('user*') || $currentPage === 'user'
                            ? 'bg-surface text-success'
                            : 'text-slate-300 hover:bg-sidebar-hover hover:text-white' }}
                    "
                >
                    <i class="fa-solid fa-users w-4 text-center text-xs"></i>
                    <span class="sidebar-text whitespace-nowrap">Users</span>
                </a>

                {{-- ROLES --}}
                <a
                    href="/role"
                    wire:navigate
                    data-tooltip="Roles"
                    class="
                        sidebar-item
                        sidebar-child-item
                        flex
                        items-center
                        gap-3
                        px-3
                        py-2
                        rounded-lg
                        text-sm
                        transition
                        duration-200
                        {{ request()->is('role*') || $currentPage === 'role'
                            ? 'bg-surface text-success'
                            : 'text-slate-300 hover:bg-sidebar-hover hover:text-white' }}
                    "
                >
                    <i class="fa-solid fa-user-shield w-4 text-center text-xs"></i>
                    <span class="sidebar-text whitespace-nowrap">Roles</span>
                </a>

                {{-- PERMISSIONS --}}
                <a
                    href="/permission"
                    wire:navigate
                    data-tooltip="Permissions"
                    class="
                        sidebar-item
                        sidebar-child-item
                        flex
                        items-center
                        gap-3
                        px-3
                        py-2
                        rounded-lg
                        text-sm
                        transition
                        duration-200
                        {{ request()->is('permission*') || $currentPage === 'permission'
                            ? 'bg-surface text-success'
                            : 'text-slate-300 hover:bg-sidebar-hover hover:text-white' }}
                    "
                >
                    <i class="fa-solid fa-key w-4 text-center text-xs"></i>
                    <span class="sidebar-text whitespace-nowrap">Permissions</span>
                </a>
            </div>

            {{-- COLLAPSED FLYOUT --}}
            <div
                id="administrations-flyout"
                class="
                    sidebar-flyout
                    hidden
                    absolute
                    left-full
                    top-0
                    ml-2
                    min-w-[190px]
                    p-2
                    rounded-lg
                    shadow-xl
                    bg-sidebar-bg
                    border
                    border-gray-700
                    z-[999]
                "
            >
                <div class="px-3 py-2 mb-1 text-xs font-semibold uppercase tracking-wider text-gray-400">
                    Administrations
                </div>

                <a
                    href="/user"
                    wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-sidebar-hover transition"
                >
                    <i class="fa-solid fa-users w-4 text-center text-xs"></i>
                    <span>Users</span>
                </a>

                <a
                    href="/role"
                    wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-sidebar-hover transition"
                >
                    <i class="fa-solid fa-user-shield w-4 text-center text-xs"></i>
                    <span>Roles</span>
                </a>

                <a
                    href="/permission"
                    wire:navigate
                    class="flex items-center gap-3 px-3 py-2 rounded-lg text-sm text-slate-300 hover:text-white hover:bg-sidebar-hover transition"
                >
                    <i class="fa-solid fa-key w-4 text-center text-xs"></i>
                    <span>Permissions</span>
                </a>
            </div>
        </div>


    </nav>

    {{-- =========================================================
         LOGOUT
    ========================================================== --}}
    <div class="p-4 shrink-0">
        <form method="POST" action="">
            @csrf
            <button
                type="submit"
                data-tooltip="Logout"
                class="
                    sidebar-item
                    w-full
                    flex
                    items-center
                    justify-center
                    gap-2
                    bg-red-500
                    hover:bg-red-600
                    text-white
                    px-4
                    py-2
                    rounded-lg
                    transition-all
                    duration-200
                    hover:scale-[1.02]
                "
            >
                <i class="fa-solid fa-right-from-bracket"></i>
                <span class="sidebar-text">Logout</span>
            </button>
        </form>
    </div>

    {{-- =========================================================
         AI STATUS
    ========================================================== --}}
    <div class="p-4 border-t border-gray-800 space-y-2 shrink-0">
        <div
            class="
                flex
                items-center
                gap-2
                px-2
                py-2
                rounded-lg
                bg-zinc-800/60
                text-slate-300
                transition
                duration-200
            "
        >
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span class="sidebar-text whitespace-nowrap text-xs">
                Gemini 2.5 Flash
            </span>
        </div>
    </div>

    {{-- =========================================================
         FOOTER
    ========================================================== --}}
    <div
        class="
            flex
            p-4
            border-t
            border-gray-800
            items-center
            text-xs
            text-gray-400
            shrink-0
        "
    >
        <span class="sidebar-text whitespace-nowrap">
            Powered By Code Ethos ©2026
        </span>
    </div>

</aside>
