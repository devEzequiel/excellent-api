<?php

namespace App\Domains\Order\Repositories;

use App\Domains\Order\Contracts\OrderRepositoryInterface;
use App\Domains\Order\Models\Order;
use App\Domains\Order\Models\OrderProduct;
use App\Domains\Product\Models\Product;
use App\Repositories\AbstractRepository;

class OrderRepository extends AbstractRepository implements OrderRepositoryInterface
{
    protected Product $productModel;
    protected OrderProduct $orderProductModel;

    public function __construct(Order $orderModel, Product $productModel, OrderProduct $orderProductModel)
    {
        parent::__construct($orderModel);
        $this->productModel = $productModel;
        $this->orderProductModel = $orderProductModel;
    }

    public function createOrder(array $data)
    {
        $data['total'] = $this->calculateTotal($data['products']);
        $order = $this->create($data);

        foreach ($data['products'] as $product) {
            $this->orderProductModel::create([
                'order_id' => $order->uuid,
                'product_id' => $product['id'],
                'quantity' => $product['quantity']
            ]);
        }

        return $order->load('products');
    }

    private function calculateTotal(array $products): float|int
    {
        $total = 0;
        foreach ($products as $product) {
            $total += $this->getProductTotal($product['id'], $product['quantity']);
        }

        return $total;
    }

    private function getProductTotal(string $productId, int $quantity): float|int
    {
        $product = $this->productModel::find($productId);

        if (!$product) {
            throw new \InvalidArgumentException("Product not found for ID: $productId");
        }

        if (!isset($product->stock) || $product->stock < $quantity) {
            throw new \RuntimeException("Insufficient stock for product: $product->description");
        }

        return $product->price * $quantity;
    }
}
