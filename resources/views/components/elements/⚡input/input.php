<?php

use Livewire\Component;
use Livewire\Attributes\Modelable;
new class extends Component
{
    #[Modelable]
    public $value = '';

    public string $type = 'text';
    public string $title = '';
    public string $id = '';
    public string $name = '';
    public string $class = '';
    public bool|string $required = false;
    public string $min = '';
    public string $max = '';
    public string $rows = '4';
    public string $cols = '50';
    public string $colspan = '2';
    public array $options = [];
    public bool|string $checked= false;
    public string $error = '';
    public bool|string $isMulti = false;


    public function mount($value = null, string $error = '')
    {
        $this->error = $error;
        if ($this->type === 'checkbox') {
            $this->value = is_array($value) ? $value : [];
        } else {
            $this->value = is_array($value) ? '' : ($value ?? '');
        }
    }



};
