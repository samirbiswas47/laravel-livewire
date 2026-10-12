<?php

use Livewire\Component;
use Livewire\Attributes\On;


new class extends Component
{
    public array $btnarray= [];
    public $filter="list";

    #[On('page-filter')]
    public function pageFilter(string $prop) : void
    {
        $this->filter = $prop;
    }
};
?>

<div class="flex items-center text-sm gap-2">
    @foreach ($btnarray as $btn)
    <button
        wire:click="$dispatch('filter-changed', '{{ strtolower($btn["title"]) }}')"
        type="button"
        class="dropdown-toggle flex items-center justify-buttom cursor-pointer py-1 px-2 rounded-md text-center transition-all duration-750 ease-in-out btn-{{$btn['color']}} gap-2  @if( trim($filter) == strtolower($btn['title']) ) opacity-100 @else opacity-40 @endif "
        >
        <div class="justify-center @if( trim($filter) == strtolower($btn['title']) ) animate-pulse-scale-3 @endif">
            {!! $btn['icon'] !!}
        </div>
        <div class="justify-center">
            {{ucwords($btn['title'])}}
        </div>
    </button>
    @endforeach
</div>
