<div class="relative profile-wrapper inline-block">
    <!-- Single combined class attribute and quoted JS parameter -->
    <button
        type="button"
        class="dropdown-toggle flex items-center justify-center cursor-pointer p-1 rounded-full text-center transition-all duration-750 ease-in-out btn-outline-{{$btn}}"
        onclick="{{ $fn }}(event, { id: '{{ $id }}' })"
    >
        <div class="w-4 h-5 justify-center  font-semibold uppercase">
            @if($type === 'icon')
                {!! $icon !!}
            @else
                {{ $title }}
            @endif
        </div>
    </button>

    <div
        id="{{ $id }}"
        class="hidden dropdown-menu absolute bottom-full right-0 mb-2 w-36 rounded-md bg-surface shadow-lg border border-border z-50 text-heading"
    >
        {{ $slot }}
    </div>
</div>
