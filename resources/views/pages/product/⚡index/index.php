<?php

use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use WithPagination;

    public $businessId;

    public $product_id;

    public $delete_id;

    public $code;

    public $name;

    public $price;

    public function mount()
    {
        $this->businessId = Auth::user()->business->id;
    }

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function save()
    {
        $this->validate();

        Product::updateOrCreate(
            [
                'id' => $this->product_id,
                'business_id' => $this->businessId,
            ],
            [
                'code' => $this->code,
                'name' => $this->name,
                'price' => $this->price,
            ]
        );

        $this->resetForm();

        $this->modal('add-product')->close();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Data produk berhasil disimpan.',
            type: 'success'
        );
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);

        $this->product_id = $product->id;
        $this->code = $product->code;
        $this->name = $product->name;
        $this->price = $product->price;

        $this->modal('add-product')->show();
    }

    public function confirmDelete($id)
    {
        $this->delete_id = $id;
        $this->modal('delete-product')->show();
    }

    public function delete()
    {
        Product::where('id', $this->delete_id)
            ->where('business_id', $this->businessId)
            ->delete();

        $this->reset('delete_id');

        $this->modal('delete-product')->close();

        $this->dispatch('notify',
            title: 'Berhasil',
            message: 'Data produk berhasil dihapus.',
            type: 'success'
        );
    }

    public function resetForm()
    {
        $this->reset([
            'product_id',
            'code',
            'name',
            'price',
        ]);
    }

    #[Computed()]
    public function products()
    {
        return Auth::user()->business
            ->products()
            ->latest()
            ->paginate(10);
    }

    #[Computed()]
    public function stats()
    {
        return [
            'total' => Product::where('business_id', $this->businessId)->count(),
        ];
    }
};
