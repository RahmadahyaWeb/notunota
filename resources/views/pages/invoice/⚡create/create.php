<?php

use App\Models\Customer;
use App\Services\InvoiceService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $customer_id;

    public $invoice_date;

    public $due_date;

    public $products = [];

    public $customers = [];

    public $items = [];

    public $subtotal = 0;

    public $total = 0;

    public $template = 'classic';

    public function mount()
    {
        $business = Auth::user()->business;

        $this->customers = $business->customers()->get();
        $this->products = $business->products()->where('is_active', true)->get();

        $this->invoice_date = now()->format('Y-m-d');
        $this->due_date = now()->addDays(7)->format('Y-m-d');

        $this->add_item();
    }

    public function add_item()
    {
        $this->items[] = [
            'product_id' => null,
            'description' => '',
            'qty' => 1,
            'price' => 0,
            'total' => 0,
        ];
    }

    public function remove_item($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculate_totals();
    }

    public function updatedItems()
    {
        $this->calculate_totals();
    }

    public function updated($property, $value)
    {
        if (str_contains($property, 'items.') && str_ends_with($property, '.product_id')) {

            $segments = explode('.', $property);
            $index = $segments[1];

            $this->handleProductChange($index, $value);
        }
    }

    protected function handleProductChange($index, $value)
    {
        if (! $value) {
            return;
        }

        $product = collect($this->products)->firstWhere('id', $value);

        if (! $product) {
            return;
        }

        $item = $this->items[$index];

        $item['description'] = $product->code;
        $item['price'] = $product->price;

        $this->items[$index] = $item;

        $this->calculate_totals();
    }

    public function calculate_totals()
    {
        $subtotal = 0;

        foreach ($this->items as $index => $item) {
            $qty = (float) $item['qty'];
            $price = (float) $item['price'];

            $line_total = $qty * $price;

            $this->items[$index]['total'] = $line_total;

            $subtotal += $line_total;
        }

        $this->subtotal = $subtotal;
        $this->total = $subtotal;
    }

    public function save(InvoiceService $invoiceService)
    {
        $this->validate([
            'customer_id' => 'required|exists:customers,id',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        $business = Auth::user()->business;

        $payload = [
            'customer_id' => $this->customer_id,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'items' => $this->items,
            'template' => $this->template,
        ];

        $invoice = $invoiceService->create($business, $payload);

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Invoice berhasil dibuat.',
            type: 'success'
        );
    }

    #[Computed()]
    public function previewData()
    {
        $customer = $this->customer_id
            ? Customer::find($this->customer_id)
            : null;

        return [
            'business' => Auth::user()->business,
            'customer' => $customer,
            'invoice_number' => 'DRAFT',
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'items' => $this->items,
            'subtotal' => $this->subtotal,
            'total' => $this->total,
            'status' => 'draft',
        ];
    }
};
