<?php

use Livewire\Component;

new class extends Component
{
    public string $content = '<p>Initial content</p>';

    public function save()
    {
        // $this->content contains the HTML from SunEditor
    }
};
?>
<form wire:submit="save" class="space-y-4">
    <div>
        <label class="block font-semibold mb-1">Body</label>
        <livewire:elements.input wire:model="editor" type="textarea" title="Editor" id="editor" :required="true" :error="$errors->first('editor')" wire:key="field-editor-{{ $errors->has('editor') }}" colspan="1" class="editor"/>
    </div>
</form>

