<?php

namespace App\Tests;

use App\Cart;
use App\Product;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes;

#[Attributes\CoversClass(Cart::class)]
#[Attributes\CoversClass(Product::class)]
class CartTest extends TestCase
{
    private Cart $cart;

    public function setUp(): void
    {
        $this->cart = new Cart([new Product("Product1", 30), new Product("Product2", 40)]);
    }

    public function testBuy(): void
    {
        $product = new Product("Pomme", 10);

        $this->cart->buy($product, 3);
        $this->assertCount(5, $this->cart->getProducts());
        $this->assertEquals(100, $this->cart->total());
    }

    public function testReset(): void
    {
        $this->cart->reset();
        $this->assertCount(0, $this->cart->getProducts());
    }

    public function testRestore(): void
    {
        $product = new Product("Pomme", 15);

        $this->cart->restore($product);
        $this->assertCount(3, $this->cart->getProducts());

    }

    public function testTotal(): void
    {
        $total = $this->cart->total();
        $this->assertEquals(70, $total);
    }

    public function testSetProducts(): void
    {
        $products = [
            new Product("Produit1",10),
            new Product("Produit2", 50),
            new Product("Produit3", 5),
            new Product("Produit4", 2)
        ];

        $this->cart->setProducts($products);
        $this->assertCount(4, $this->cart->getProducts());
    }
}
