<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $title;

    public $message;

    public $type = 'info';

    // Tambahan untuk tombol aksi
    public $actionButton = false; // false = tombol tidak tampil

    #[On('notify')]
    public function show($title, $message, $type = 'info', $actionButton = false)
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;
        $this->actionButton = $actionButton; // bisa berupa ['text' => 'Lihat Invoice', 'route' => route('invoice.index')]

        $this->modal('notification')->show();
    }
};
