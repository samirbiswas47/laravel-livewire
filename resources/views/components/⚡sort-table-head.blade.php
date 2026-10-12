<?php

use Livewire\Component;
use Livewire\Attributes\On;
new class extends Component
{
    public string $theadName = '';
    public string $sortField = 'name';
    public string $sortDirection = 'desc';
    public string $sortName = '';

    #[On('prop-data')]
    public function propData(array $payload): void
    {
        [$this->sortField, $this->sortDirection] = $payload;
    }

};
?>

<button  wire:click="$dispatch('filter-sort-by', '{{ str_replace(" ","_",strtolower($theadName)) }}')" type="button" class="group flex items-center gap-1.5 hover:text-sidebar-text transition">
    <span>{{$theadName}}</span>
    <span class="text-xs text-muted">
        @if ($sortField === $sortName)
            <i class="fas fa-sort-{{ $sortDirection === 'asc' ? 'up' : 'down ' }}"></i>
        @else
            <i class="fas fa-sort opacity-40 group-hover:opacity-100"></i>
        @endif
    </span>
</button>
