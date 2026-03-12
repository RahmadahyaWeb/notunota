<?php

use App\Livewire\Concerns\HandlesAuthorization;
use App\Models\Product;
use App\Services\ProductService;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Livewire\WithPagination;

new class extends Component
{
    use HandlesAuthorization;
    use WithPagination;

    public $product_id;

    public $delete_id;

    public $code;

    public $name;

    public $price;

    public function mount()
    {
        $this->authorize('viewAny', [Product::class, tenant()]);
    }

    protected function rules()
    {
        return [
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
        ];
    }

    public function save(ProductService $service)
    {
        $this->authorizeAction(
            function () use ($service) {
                $this->authorize('create', [Product::class, tenant()]);

                $this->validate();

                $service->save([
                    'id' => $this->product_id,
                    'code' => $this->code,
                    'name' => $this->name,
                    'price' => $this->price,
                ]);

                $this->resetForm();

                $this->modal('add-product')->close();

                $this->dispatch('notify',
                    title: 'Berhasil',
                    message: 'Data produk berhasil disimpan.',
                    type: 'success'
                );
            }
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

    public function delete(ProductService $service)
    {
        $this->authorizeAction(function () use ($service) {
            $product = authorize_model('delete', Product::class, $this->delete_id);

            $service->delete($product->id);

            $this->reset('delete_id');

            $this->modal('delete-product')->close();

            $this->dispatch('notify',
                title: 'Berhasil',
                message: 'Data produk berhasil dihapus.',
                type: 'success'
            );
        });
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

    #[Computed]
    public function products()
    {
        return Product::query()
            ->latest()
            ->paginate(10);
    }

    #[Computed]
    public function stats()
    {
        return [
            'total' => Product::count(),
        ];
    }
};
