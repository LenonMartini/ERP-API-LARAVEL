<?php

namespace App\Repositories\Product;

use App\Models\Product;
use App\Repositories\Product\Contracts\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{


    public function all()
    {
        return Product::all();
    }

    public function find($id)
    {
        return Product::findOrFail($id);
    }

    public function create(array $data)
    {
        return Product::create($data);
    }

    public function update($id, array $data)
    {
        $model = Product::findOrFail($id);
        $model->update($data);
        return $model;
    }

    public function delete($id)
    {
        return Product::destroy($id);
    }

}
