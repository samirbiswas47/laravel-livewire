<?php

use Livewire\Component;

new class extends Component
{
    public $title;
    public $colspan;
    public $scale="false";
    public $shadow="lg";
}
?>

<div class="group col-span-{{$colspan}} rounded-xl border p-5 hover:shadow-{{$shadow}} transition-all duration-200 @if($scale=='true') overflow-hidden hover:scale-y-105 @endif">
    <div class="flex items-center justify-between mb-3 max-h-6 >
        <h3 class="text-lg font-semibold ">{{$title}}</h3>
    </div>
    {{ $slot }}
</div>
