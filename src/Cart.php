<?php

namespace App;

use App\Product;
class Cart
{
    private array $products = [];

    public function __construct(array $products) {
        $this->products = $products;
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function setProducts(array $products): void
    {
        $this->products = $products;
    }

    public function buy(Product $product, int $number)
    {
        for ($i = 0; $i<$number; $i++){
            $this->products[] = $product;
        }
    }

    public function reset(): void
    {
        $this->products = [];
    }
    public function restore(Product $product): void
    {
        $this->products[] = $product;
    }

    public function total(): string
    {
        $total = 0;
        foreach ($this->products as $product)
        {
            $total += $product->getPrice();
        }
        return $total;
    }

}
