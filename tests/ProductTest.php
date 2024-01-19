<?php

namespace App\Tests;

use App\Product;
use PHPUnit\Framework\Attributes;
use PHPUnit\Framework\TestCase;

#[Attributes\CoversClass(Product::class)]
class ProductTest extends TestCase
{
    private Product $product;

    public function setUp(): void
    {
        $this->product = new Product('Nom', '90');
    }

    public function testGetName(): void
    {
        $this->assertEquals("Nom", $this->product->getName());
    }

    public function testGetPrice(): void
    {
        $this->assertEquals("90", $this->product->getPrice());
    }

    public function testSetName(): void
    {
        $this->product->setName("newNom");
        $this->assertEquals("newNom", $this->product->getName());
    }

    public function testSetPrice(): void
    {
        $this->product->setPrice("150");
        $this->assertEquals("150", $this->product->getPrice());
    }
}
