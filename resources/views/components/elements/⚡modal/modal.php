<?php

use Livewire\Component;
use Livewire\Attributes\On;
use Masmerise\Toaster\Toaster;

new class extends Component {
    public bool $isOpen = false;
    public string $message="";
    public string $type='icon';
    public string $icon = "<i class='fas fa-plus'></i>";
    public string $title= "Add User";
    public string $width = "full";
    public string $size = "2xl";



    #[On('open-modal')]
    public function openModal(string $title = 'Add User'): void
    {
        $this->title = $title;
        $this->isOpen = true;
    }


    #[On('close-modal')]
    public function closeModal(): void
    {
        $this->isOpen = false;
    }

    public function close(): void
    {
        $this->isOpen = false;
    }

    public function confirm(): void
    {
        // Execute server logic
        $this->close();
    }

    #[On('success-message')]
    public function successMessage(string $msg): void
    {
        Toaster::success($msg);
    }
    #[On('error-message')]
    public function errorMessage(string $msg): void
    {
        Toaster::error($msg);
    }

};
