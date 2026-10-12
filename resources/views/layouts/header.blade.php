<!-- Header Wrapper changes dynamically using surface-color & heading-color -->
<header class="bg-surface text-heading shadow px-4 py-3 flex items-center justify-between border-b border-border">

    <!-- Left Portion -->
    <div class="flex items-center gap-3">
        <!-- Toggle button uses our generic semantic button tokens -->
        <button
            onclick="toggleSidebar()"
            class="inline-flex items-center justify-center px-3 py-2 rounded-lg bg-btn-neutral text-heading  transition">
            <i class="fa-solid fa-bars"></i>
        </button>

        <h1 class="font-semibold text-lg text-heading">
            {{-- pagetitle --}}
        </h1>
    </div>

    <!-- Right Portion -->
    <div class="flex items-center gap-2 md:gap-4">

        <!-- Search Input -->
        <input
            type="text"
            placeholder="Search..."
            class="hidden md:block border border-border bg-input-bg text-heading rounded px-3 py-2 w-56 focus:outline-none">

        <!-- Theme Switcher Button -->
        <button
            id="theme-toggle-btn"
            onclick="cycleThemes()"
            class="logo-profile w-8 h-8 rounded-full flex items-center justify-center bg-background  hover:bg-btn-neutral-hover transition font-medium">
            <i id="theme-icon" class="fas fa-sun"></i>
        </button>

        <!-- User Profile Wrapper -->
        <div class="relative profile-wrapper">
            <button
                type="button"
                onclick="toggleProfileDropdown(event)"
                class="flex items-center gap-2 focus:outline-none">

                <!-- Fixed width/height + shrink-0 ensures a perfect circle -->
                <div class="logo-profile w-8 h-8 rounded-full flex items-center justify-center bg-background  hover:bg-btn-neutral-hover transition font-medium">
                    A
                </div>

                <div class="hidden md:flex flex-col text-left">
                    <span class="text-sm font-medium text-heading">
                        Admin
                    </span>
                </div>
            </button>

            <!-- Profile Dropdown Menu -->
            <div
                id="profileDropdown"
                class="hidden absolute right-0 mt-3 w-56 bg-surface text-heading rounded-xl shadow-lg border border-border z-50">

                <div class="p-4 border-b border-border">
                    <p class="font-semibold text-heading">Admin</p>
                    <p class="text-sm text-muted">admin@example.com</p>
                </div>

                <div class="p-2">
                    <a href="#" class="flex items-center gap-2 px-4 py-2 rounded hover:bg-item-hover text-heading">
                        <i class="fa-solid fa-user text-muted"></i>
                        Profile
                    </a>

                    <form method="POST" action="">
                        @csrf
                        <button
                            type="submit"
                            class="w-full flex items-center gap-2 px-4 py-2 rounded text-red-500 hover:bg-red-50/10 transition">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>
