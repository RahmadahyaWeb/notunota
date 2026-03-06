<?php

use Livewire\Attributes\On;
use Livewire\Component;

new class extends Component
{
    public $title;

    public $message;

    public $type = 'info';

    #[On('notify')]
    public function show($title, $message, $type = 'info')
    {
        $this->title = $title;
        $this->message = $message;
        $this->type = $type;

        $this->modal('notification')->show();
    }
};
