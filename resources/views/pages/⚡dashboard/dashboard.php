<?php

use App\Models\Invoice;
use Carbon\Carbon;
use Livewire\Component;

new class extends Component
{
    public $total_invoice;

    public $paid_invoice;

    public $unpaid_invoice;

    public $revenue_month;

    public $recent_invoices = [];

    public $due_invoices = [];

    public $greeting;

    public function mount()
    {
        $this->load_data();

        $this->set_greeting();
    }

    public function load_data()
    {
        $this->total_invoice = Invoice::count();

        $this->paid_invoice = Invoice::where('status', 'paid')->count();

        $this->unpaid_invoice = Invoice::where('status', 'unpaid')->count();

        $this->revenue_month = Invoice::where('status', 'paid')
            ->whereMonth('paid_at', now()->month)
            ->sum('total');

        $this->recent_invoices = Invoice::latest()
            ->limit(5)
            ->get();

        $this->due_invoices = Invoice::where('status', 'unpaid')
            ->orderBy('due_date')
            ->limit(5)
            ->get();
    }

    public function set_greeting()
    {
        $hour = Carbon::now()->hour;

        if ($hour >= 4 && $hour < 11) {
            $this->greeting = 'Selamat pagi';
        } elseif ($hour >= 11 && $hour < 15) {
            $this->greeting = 'Selamat siang';
        } elseif ($hour >= 15 && $hour < 18) {
            $this->greeting = 'Selamat sore';
        } else {
            $this->greeting = 'Selamat malam';
        }
    }
};
