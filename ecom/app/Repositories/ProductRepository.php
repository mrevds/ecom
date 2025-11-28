<?php

namespace App\Repositories;
use App\Models\Products;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;



class ProductRepository {
    public function create(array $data): Products
    {
        return Products::create($data);
    }
    public function findById(int $id): ?Products
    {
        return Cache::remember("product:{$id}", 3600, function () use ($id) {
            return Products::find($id);
        });
    }
    public function getAll(array $filters = [])
    {
        $query = Products::with(['category', 'seller']);

        if (isset($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }
        if (isset($filters['seller_id'])) {
            $query->where('seller_id', $filters['seller_id']);
        }
        if (isset($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate(10);
    }

    public function update(int $id, array $data): bool
    {
        $product = $this->findById($id);
        return $product ? $product->update($data) : false;
    }

    public function delete(int $id): bool
    {
        $product = $this->findById($id);
        return $product ? $product->delete(): false;
    }
    public function getProductPrice(int $productId): float
    {
        $productPrice = $this->findById($productId);
        return $productPrice ? $productPrice->price : 0;
    }
    public function getProductStock($productId)
    {
        $product = $this->findById($productId);
        return $product ? $product->stock : 0;
    }
}
