<?php

namespace App\Services;


use App\Models\Products;
use App\Repositories\ProductRepository;
use Illuminate\Support\Str;


class ProductService {
    public function __construct(
        private ProductRepository $productRepository
    ){}

    public function createProduct(int $sellerId, array $data): Products
    {
        $productData = [
            'seller_id' => $sellerId,
            'category_id' => $data['category_id'],
            'name' => $data['name'],
            'slug' => Str::slug($data['name']),
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'status' => 'draft'
        ];

        return $this->productRepository->create($productData);
    }

    public function getProducts(array $filters = [])
    {
        return $this->productRepository->getAll($filters);
    }

    public function getProductByID(int $id): ?Products
    {
        return $this->productRepository->findById($id);
    }

    public function updateProduct(int $id, int $sellerId, array $data, bool $isAdmin = false): bool
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return false;
        }

        if (!$isAdmin && $product->seller_id !== $sellerId) {
            return false;
        }

        $update_data = [];

        if (isset($data['name'])) {
            $update_data['name'] = $data['name'];
            $update_data['slug'] = Str::slug($data['name']);
        }

        if (isset($data['description'])) {
            $update_data['description'] = $data['description'];
        }
        if (isset($data['price'])) {
            $update_data['price'] = $data['price'];
        }
        if (isset($data['stock'])) {
            $update_data['stock'] = $data['stock'];
        }
        if (isset($data['status'])) {
            $update_data['status'] = $data['status'];
        }
        return $this->productRepository->update($id, $update_data);
    }
    public function deleteProduct(int $id, int $sellerId, bool $isAdmin = false): bool
    {
        $product = $this->productRepository->findById($id);

        if (!$product) {
            return false;
        }

        if (!$isAdmin && $product->seller_id !== $sellerId) {
            return false;
        }

        return $this->productRepository->delete($id);
    }
}
