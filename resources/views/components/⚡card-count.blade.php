<?php

use Livewire\Component;

new class extends Component
{
    public $count;
    public $toggle;
    public $description;
    public $toggleShow=false;
    public $countLable;


    public function toggleDetails(){
        $this->toggleShow= !$this->toggleShow;
    }

};
?>

<div>
    <div class="flex items-center text justify-between mb-3 max-h-6 group-hover:scale-y-110">
        <span class="inline-flex items-center gap-1 text-indigo-600 font-bold">{{$countLable}}: {{$count}}</span>
        @if($toggle=='true')
            <button wire:click="toggleDetails" class="inline-flex gap-2 p-2 text-sm font-medium cursor-pointer hover:animate-shake"><i class="fas fa-eye animate-pulse-scale-3 "></i></button>
        @endif
    </div>
    @if($toggleShow)
            <div class="mt-4 pt-4 border-t  leading-relaxed"> {{$description?? 'dejsdfhkhkfhdskh' }}</div>
            @endif
    {{ $slot }}

</div>
