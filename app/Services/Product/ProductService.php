<?php

namespace App\Services\Product;

use App\Repositories\Product\ProductRepository;

class ProductService
{


    public function index()
    {
        return app(ProductRepository::class)->all();
    }

    public function show($id)
    {
        return app(ProductRepository::class)->find($id);
    }

    public function store($data)
    {
        return app(ProductRepository::class)->create($data);
    }

    public function update($id, $data)
    {
        return app(ProductRepository::class)->update($id, $data);
    }

    public function destroy($id)
    {
        return app(ProductRepository::class)->delete($id);
    }

}
