<?php
// app/Http/Controllers/ProductController.php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService
    ) {}

    public function index(Request $request)
    {
        $filters = $request->only(['category_id', 'seller_id', 'status']);
        $products = $this->productService->getProducts($filters);

        return response()->json($products);
    }

    public function show(int $id)
    {
        $product = $this->productService->getProductById($id);

        if (!$product) {
            return response()->json(['error' => 'Product not found'], 404);
        }

        return response()->json($product);
    }

    public function store(StoreProductRequest $request)
    {
        $product = $this->productService->createProduct(
            $request->user()->id,
            $request->validated()
        );

        return response()->json($product, 201);
    }

    public function update(Request $request, int $id)
    {
        $isAdmin = $request->user()->role_id === 3;

        $updated = $this->productService->updateProduct(
            $id,
            $request->user()->id,
            $request->all(),
            $isAdmin
        );

        if (!$updated) {
            return response()->json(['error' => 'Cannot update product'], 403);
        }

        return response()->json(['message' => 'Product updated']);
    }

    public function destroy(Request $request, int $id)
    {
        $isAdmin = $request->user()->role_id === 3;

        $deleted = $this->productService->deleteProduct(
            $id,
            $request->user()->id,
            $isAdmin
        );

        if (!$deleted) {
            return response()->json(['error' => 'Cannot delete product'], 403);
        }

        return response()->json(['message' => 'Product deleted']);
    }
}
