<?php

use Livewire\Component;

new class extends Component
{
    public $data;
};
?>
<div class="w-full">
    {{print_r($data)}}

    {{-- =====================================================
        TABLE HEADER
    ====================================================== --}}

    <div class="mb-4 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        {{-- Search --}}

        <div class="relative w-full sm:w-64">

            <i
                class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-muted"
            ></i>

            <input
                type="text"
                placeholder="Search users..."
                class="
                    w-full
                    rounded-lg
                    border
                    border-border
                    bg-input-bg
                    py-2
                    pl-10
                    pr-3
                    text-sm
                    text-heading
                    outline-none
                    transition
                    focus:border-indigo-500
                    focus:ring-2
                    focus:ring-indigo-500/20
                "
            >

        </div>

    </div>


    {{-- =====================================================
        TABLE
    ====================================================== --}}

    <div
        class="
            overflow-hidden
            rounded-xl
            border
            border-border
            bg-surface
        "
    >

        <div class="overflow-visible">

            <table class="w-full text-left text-sm">

                {{-- Table Head --}}

                <thead
                    class="
                        border-b
                        border-border
                        bg-item-hover
                    "
                >

                    <tr>

                        <th class="px-5 py-3 font-semibold text-heading">
                            #
                        </th>

                        <th class="px-5 py-3 font-semibold text-heading">
                            User
                        </th>

                        <th class="px-5 py-3 font-semibold text-heading">
                            Email
                        </th>

                        <th class="px-5 py-3 font-semibold text-heading">
                            Role
                        </th>

                        <th class="px-5 py-3 font-semibold text-heading">
                            Status
                        </th>

                        <th class="px-5 py-3 font-semibold text-heading">
                            Joined
                        </th>

                        <th class="px-5 py-3 text-right font-semibold text-heading">
                            Action
                        </th>

                    </tr>

                </thead>


                {{-- Table Body --}}

                <tbody class="divide-y divide-border">

                    {{-- Row 1 --}}

                    <tr class="transition hover:bg-item-hover">

                        <td class="px-5 py-4 text-muted">
                            1
                        </td>


                        {{-- User --}}

                        <td class="px-5 py-4">

                            <div class="flex items-center gap-3">

                                <div
                                    class="
                                        flex
                                        h-10
                                        w-10
                                        items-center
                                        justify-center
                                        rounded-full
                                        bg-indigo-100
                                        font-semibold
                                        text-indigo-600
                                    "
                                >
                                    SB
                                </div>

                                <div>

                                    <p class="font-semibold text-heading">
                                        Samir Biswas
                                    </p>

                                    <p class="text-xs text-muted">
                                        @samir
                                    </p>

                                </div>

                            </div>

                        </td>


                        <td class="px-5 py-4 text-muted">
                            samir@example.com
                        </td>


                        <td class="px-5 py-4">

                            <span
                                class="
                                    rounded-full
                                    bg-indigo-100
                                    px-2.5
                                    py-1
                                    text-xs
                                    font-medium
                                    text-indigo-700
                                "
                            >
                                Admin
                            </span>

                        </td>


                        <td class="px-5 py-4">

                            <span
                                class="
                                    inline-flex
                                    items-center
                                    gap-1.5
                                    rounded-full
                                    bg-emerald-100
                                    px-2.5
                                    py-1
                                    text-xs
                                    font-medium
                                    text-emerald-700
                                "
                            >
                                <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>
                                Active
                            </span>

                        </td>

                        <td class="px-5 py-4 text-muted">
                            Sep 24, 2026
                        </td>


                        <td class="px-5 py-4 text-right">

                            <livewire:dropdown-menu
                                title="click"
                                colspan="1"
                                type="icon"
                                icon='<i class="fas fa-ellipsis-v"></i>'
                                id="dropdown"
                                textcolor="red-900"
                                menualign="right"
                                margin="[10px]"
                                width="40"
                                zindex="[9999]"
                            >


                                <div class="p-2">
                                    <a href="#"
                                        class="flex items-center gap-2 px-4 py-2 rounded hover:bg-item-hover text-heading">
                                        <i class="fa-solid fa-user text-muted"></i>
                                        Demo
                                    </a>
                                </div>
                            </livewire:dropdown-menu>

                        </td>
                    </tr>
                </tbody>
            </table>

        </div>


        {{-- =================================================
            TABLE FOOTER
        ================================================== --}}

        <div
            class="
                flex
                flex-col
                gap-3
                border-t
                border-border
                px-5
                py-4

                sm:flex-row
                sm:items-center
                sm:justify-between
            "
        >

            <p class="text-sm text-muted">
                Showing
                <span class="font-medium text-heading">1</span>
                to
                <span class="font-medium text-heading">3</span>
                of
                <span class="font-medium text-heading">25</span>
                results
            </p>


            <div class="flex items-center gap-1">

                <button
                    class="
                        rounded-lg
                        border
                        border-border
                        px-3
                        py-2
                        text-sm
                        text-muted
                        transition
                        hover:bg-item-hover
                    "
                >
                    <i class="fas fa-chevron-left"></i>
                </button>


                <button
                    class="
                        rounded-lg
                        bg-indigo-600
                        px-3
                        py-2
                        text-sm
                        font-medium
                        text-white
                    "
                >
                    1
                </button>


                <button
                    class="
                        rounded-lg
                        border
                        border-border
                        px-3
                        py-2
                        text-sm
                        text-muted
                        transition
                        hover:bg-item-hover
                    "
                >
                    2
                </button>


                <button
                    class="
                        rounded-lg
                        border
                        border-border
                        px-3
                        py-2
                        text-sm
                        text-muted
                        transition
                        hover:bg-item-hover
                    "
                >
                    3
                </button>


                <button
                    class="
                        rounded-lg
                        border
                        border-border
                        px-3
                        py-2
                        text-sm
                        text-muted
                        transition
                        hover:bg-item-hover
                    "
                >
                    <i class="fas fa-chevron-right"></i>
                </button>

            </div>

        </div>

    </div>

</div>



