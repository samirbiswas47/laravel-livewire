<div
    x-data="{ show: @entangle('isOpen').live }"
    x-on:close-modal.window="show = false"
    wire:ignore.self
>
    <!-- Trigger Button (Add User) -->
    <button wire:click="$dispatch('open-create-user')" type="button" class="px-2 py-2.5 btn btn-outline-primary rounded">
        {!! $icon !!}
    </button>

    <div
        x-show="show"
        x-cloak
        wire:ignore.self
        class="fixed inset-0 z-50 flex items-start justify-center overflow-y-auto bg-black/50 pt-16 px-4 pb-6"
        x-on:keydown.escape.window="show = false; $wire.close()"
        style="display: none;"
    >
        <div class="bg-background p-6 pb-0 rounded-xl shadow-lg w-{{$width}} max-w-{{$size}} mx-4" wire:ignore.self @click.stop>
            @if($title)
                <div class="flex items-center justify-between pb-3 border-b border-gray-200 mb-4">
                    <h3 class="text-lg font-bold">{{ $title }}</h3>
                    <button @click="show = false; $wire.close()" type="button" class="text-gray-400 hover:text-gray-600 text-xl font-bold leading-none">&times;</button>
                </div>
            @endif

            {{ $slot }}
        </div>
    </div>
</div>
