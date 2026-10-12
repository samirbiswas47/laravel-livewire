<?php

use Livewire\Component;

new class extends Component
{
    // public $type;
    // public $title;
    // public $id;
    // public $name;
    // public $value;
    // public $class;
    // public $required = "false";
    // public $cols=4;
    // public $rows=5;
    public string $description = 'fsfsdf';

    public string $notes = 'dfsdertre fhgfh';

    public function save()
    {
        dd([
            'description' => $this->description,
            'notes' => $this->notes,
        ]);
    }
};
