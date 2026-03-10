<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    public function save(array $data): Product
    {
        return Product::updateOrCreate(
            ['id' => $data['id'] ?? null],
            [
                'code' => $data['code'],
                'name' => $data['name'],
                'price' => $data['price'],
            ]
        );
    }

    public function delete(int $id): void
    {
        Product::where('id', $id)->delete();
    }
}
