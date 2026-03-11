<?php

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
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

    public $chart_labels = [];

    public $chart_data = [];

    public function mount()
    {
        $this->load_data();

        $this->set_greeting();
    }

    public function load_data()
    {
        $this->total_invoice = Invoice::count();

        $this->paid_invoice = Invoice::where('status', 'paid')->count();

        $this->unpaid_invoice = Invoice::where('status', 'sent')->count();

        $this->revenue_month = Invoice::where('status', 'paid')
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('total');

        $this->recent_invoices = Invoice::latest()->take(5)->get();

        $this->due_invoices = Invoice::where('status', 'sent')
            ->whereDate('due_date', '<=', Carbon::now()->addDays(7))
            ->get();

        $this->loadRevenueChart();
    }

    public function loadRevenueChart()
    {
        $startDate = Carbon::now()->subDays(29)->startOfDay();
        $endDate = Carbon::now()->endOfDay();

        $revenues = Invoice::select(
            DB::raw('DATE(invoice_date) as date'),
            DB::raw('SUM(total) as total')
        )
            ->where('status', 'paid')
            ->whereBetween('invoice_date', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->keyBy('date');

        $labels = [];
        $data = [];

        for ($i = 0; $i < 30; $i++) {

            $date = $startDate->copy()->addDays($i)->format('Y-m-d');

            $labels[] = Carbon::parse($date)->format('d M');

            $data[] = $revenues[$date]->total ?? 0;
        }

        $this->chart_labels = $labels;
        $this->chart_data = $data;
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
