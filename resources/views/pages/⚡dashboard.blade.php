<?php

use Livewire\Component;

new class extends Component
{
    public $data=[];
    public $icon;
    public string $name = '';
    public ?int $age = null;
    public string $email = '';
    public string $password = '';
    public string $status = '';
    public array $gender = [];
    public string $desc = '';

    public array $statusOptions = [
        'active' => 'Active',
        'inactive' => 'Inactive',
    ];
    public array $gendOptions = [
        'M' => 'Male',
        'F' => 'Female',
    ];


    public function save()
    {
        // All child inputs are already populated in these properties:
        $data = $this->validate([
            'name'     => 'required|string',
            'age'      => 'required|numeric|min:0',
            'email'    => 'required|email',
            'password' => 'required',
            'status'   => 'required',
            'gender'   => 'required|array|min:1',
            'desc'     => 'required|string'
        ], [
            'gender.required' => 'Please select at least one gender option.',
            'gender.min'      => 'Please select at least one gender option.',
        ]);
        dump($data);
        // Proceed with saving $data...
    }

    public function resetForm()
    {
        $this->reset(['name', 'age', 'email', 'password', 'status', 'desc', 'gender']);
    }
};
?>

<div>
    <div class="grid md:grid-cols-4 sm:grid-cols-2 xs:grid-cols-1 gap-4 h-auto pb-5">
        <!-- Cards -->
        <livewire:widget.dashboard-card title="Users" colspan="1" scale="true" shadow="lg">
            <livewire:card-count countLable="Total" count="10" description="fgdg" toggle="true" />
        </livewire:widget.dashboard-card>
        <livewire:widget.dashboard-card title="Order" colspan="1" scale="true" shadow="lg">
            <livewire:card-count countLable="Total" count="5000" description="fgdg" />
        </livewire:widget.dashboard-card>
        <livewire:widget.dashboard-card title="Customer" colspan="1" scale="true">
            <livewire:card-count countLable="Total" count="10" description="fgdg" toggle="true"/>
        </livewire:widget.dashboard-card>
        <livewire:widget.dashboard-card title="Job" colspan="1">
            <livewire:card-count countLable="Total" count="10" description="fgdg" toggle="true"/>
        </livewire:widget.dashboard-card>
    </div>
    <div class="border w-full">
        <form wire:submit="save" class="w-full py-5 px-4 h-auto">

            <!-- 1. Form Inputs Grid -->
            <div class="w-full grid grid-cols-1 md:grid-cols-2 gap-6">

                <livewire:elements.input
                    wire:model="name"
                    type="text"
                    title="Name"
                    id="name"
                    :required="true"
                    :error="$errors->first('name')"
                    wire:key="field-name-{{ $errors->has('name') }}"
                    colspan="1"
                />

                <livewire:elements.input
                    wire:model="age"
                    type="number"
                    title="Age"
                    id="age"
                    min="0"
                    :required="true"
                    :error="$errors->first('age')"
                    wire:key="field-age-{{ $errors->has('age') }}"
                    colspan="1"
                />

                <livewire:elements.input
                    wire:model="email"
                    type="email"
                    title="Email"
                    id="email"
                    :required="true"
                    :error="$errors->first('email')"
                    wire:key="field-email-{{ $errors->has('email') }}"
                    colspan="1"
                />

                <livewire:elements.input
                    wire:model="password"
                    type="password"
                    title="Password"
                    id="password"
                    :required="true"
                    :error="$errors->first('password')"
                    wire:key="field-password-{{ $errors->has('password') }}"
                    colspan="1"
                />

                <livewire:elements.input
                    wire:model="status"
                    type="radio"
                    title="Status"
                    id="status"
                    :options="$statusOptions"
                    :required="true"
                    :error="$errors->first('status')"
                    wire:key="field-status-{{ $errors->has('status') }}"
                    colspan="1"
                />

                <livewire:elements.input
                    wire:model="gender"
                    type="checkbox"
                    title="Gender"
                    id="gender"
                    name="gender"
                    :options="$gendOptions"
                    :error="$errors->first('gender')"
                    wire:key="field-gender-{{ $errors->has('gender') }}"
                    colspan="1"
                />

                <!-- Textarea: Spans both grid columns -->
                <div class="col-span-1">
                    <livewire:elements.input
                        wire:model="desc"
                        type="textarea"
                        title="Description"
                        id="desc"
                        cols="6"
                        rows="5"
                        :required="true"
                        :error="$errors->first('desc')"
                        wire:key="field-desc-{{ $errors->has('desc') }}"
                        colspan="1"
                    />
                </div>

            </div> <!-- /grid closes here -->


            <!-- 2. Independent Full-Width Button Container (Non-Grid) -->
            <div class="w-full flex justify-end items-center gap-3 py-4 mt-6 border-t border-gray-200">
                <button type="submit" class="px-5 py-2 btn btn-outline-primary rounded">Save</button>
                <button type="reset" wire:click="resetForm" class="px-5 py-2 btn btn-outline-warning rounded">Reset</button>
            </div>

        </form>
    </div>

</div>
