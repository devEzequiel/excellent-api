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

    public function getOrders()
    {
        $orders = $this->getAll();
        return $orders->load('products');
    }

    public function getOrderById(string $uuid)
    {
       $order = $this->getById($uuid);
       return $order->load('products');
    }

    public function deleteOrder(string $uuid): bool
    {
        $order = $this->getById($uuid);
        $orderProducts = $this->orderProductModel::where('order_id', $uuid)->get();

        $orderProducts->each(function ($orderProduct) {
            $product = $this->productModel::find($orderProduct->product_id);
            $product->increment('stock', $orderProduct->quantity);
            $orderProduct->delete();
        });

        return $order->delete();
    }

    public function updateOrder(string $uuid, array $data)
    {
        $order = $this->getById($uuid);

        foreach ($data['products'] as $product) {
            $orderProduct = $this->orderProductModel::where('order_id', $uuid)
                ->where('product_id', $product['id'])
                ->first();

            $productModel = $this->productModel::find($product['id']);

            if ($orderProduct) {
                $oldQuantity = $orderProduct->quantity;
                $quantityDiff = $product['quantity'] - $oldQuantity;

                if ($quantityDiff > 0 && (!isset($productModel->stock) || $productModel->stock < $quantityDiff)) {
                    throw new \RuntimeException("Insufficient stock for product: $productModel->description");
                }

                $productModel->decrement('stock', $quantityDiff);
                $orderProduct->update(['quantity' => $product['quantity']]);
            } else {
                if (!isset($productModel->stock) || $productModel->stock < $product['quantity']) {
                    throw new \RuntimeException("Insufficient stock for product: $productModel->description");
                }

                $productModel->decrement('stock', $product['quantity']);
                $this->orderProductModel::create([
                    'order_id' => $order->uuid,
                    'product_id' => $product['id'],
                    'quantity' => $product['quantity']
                ]);
            }
        }

        $data['total'] = $this->calculateTotal($data['products']);
        $order->update($data);

        return $order->load('products');
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

            $productModel = $this->productModel::find($product['id']);
            $productModel->decrement('stock', $product['quantity']);
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
