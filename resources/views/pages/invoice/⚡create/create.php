<?php

use App\Models\Customer;
use App\Services\CustomerService;
use App\Services\InvoiceService;
use Livewire\Attributes\Computed;
use Livewire\Component;

new class extends Component
{
    public $customer_id;

    public $invoice_date;

    public $due_date;

    public $items = [];

    public $products = [];

    public $customers = [];

    public $subtotal = 0;

    public $total = 0;

    public $template = 'classic';

    public $invoice;

    // customer form
    public $code;

    public $name;

    public $email;

    public $phone;

    public $address;

    public function mount($token = null)
    {
        $business = tenant();

        $this->customers = $business->customers()->get();
        $this->products = $business->products()
            ->where('is_active', true)
            ->get();

        if ($token) {

            $invoice = $business->invoices()
                ->with('items')
                ->where('public_token', $token)
                ->firstOrFail();

            $this->invoice = $invoice;

            $this->customer_id = $invoice->customer_id;
            $this->invoice_date = $invoice->invoice_date;
            $this->due_date = $invoice->due_date;
            $this->template = $invoice->template;

            $this->items = $invoice->items->map(fn ($item) => [
                'product_id' => $item->product_id,
                'description' => $item->description,
                'qty' => $item->qty,
                'price' => $item->price,
                'total' => $item->total,
            ])->toArray();

            $this->calculateTotals();

        } else {

            $this->invoice_date = now()->format('Y-m-d');
            $this->due_date = now()->addDays(7)->format('Y-m-d');

            $this->addItem();
        }
    }

    public function addItem()
    {
        $this->items[] = [
            'product_id' => null,
            'name' => null,
            'description' => '',
            'qty' => 1,
            'price' => 0,
            'total' => 0,
        ];
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);

        $this->calculateTotals();
    }

    public function updatedItems()
    {
        $this->calculateTotals();
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

        $item['name'] = $product->name;
        $item['description'] = $product->code.' - '.$product->name;
        $item['price'] = $product->price;

        $this->items[$index] = $item;

        $this->calculateTotals();
    }

    public function calculateTotals()
    {
        $subtotal = 0;

        foreach ($this->items as $i => $item) {

            $line = (int) ($item['qty'] ?? 0) * (int) ($item['price'] ?? 0);

            $this->items[$i]['total'] = $line;

            $subtotal += $line;
        }

        $this->subtotal = $subtotal;
        $this->total = $subtotal;
    }

    public function save(InvoiceService $service)
    {
        $this->validate([
            'customer_id' => 'required',
            'invoice_date' => 'required|date',
            'items' => 'required|array|min:1',
        ]);

        $payload = [
            'customer_id' => $this->customer_id,
            'invoice_date' => $this->invoice_date,
            'due_date' => $this->due_date,
            'items' => $this->items,
            'template' => $this->template,
        ];

        if ($this->invoice) {

            $invoice = $service->update($this->invoice, $payload);

        } else {

            $invoice = $service->create(tenant(), $payload);
        }

        $this->resetForm();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Invoice berhasil disimpan.',
            type: 'success'
        );
    }

    public function resetForm()
    {
        $this->customer_id = null;
        $this->items = [];
        $this->subtotal = 0;
        $this->total = 0;

        $this->addItem();
    }

    public function saveCustomer(CustomerService $service)
    {
        $this->validate([
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:30',
            'address' => 'nullable|string',
        ]);

        $customer = $service->save([
            'code' => $this->code,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
        ]);

        $this->customers = tenant()->customers()->get();

        $this->customer_id = $customer->id;

        $this->resetFormAddCustomer();

        $this->modal('add-customer')->close();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Customer berhasil ditambahkan.',
            type: 'success'
        );
    }

    public function resetFormAddCustomer()
    {
        $this->code = null;
        $this->name = null;
        $this->email = null;
        $this->phone = null;
        $this->address = null;
    }

    #[Computed]
    public function previewData()
    {
        return [
            'business' => tenant(),
            'customer' => $this->customer_id
                ? Customer::find($this->customer_id)
                : null,
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
