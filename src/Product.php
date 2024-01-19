<?php

namespace App;

class Product
{
    private string $name;
    private string $price;

    public function __construct(String $name, String $price)
    {
        $this->name = $name;
        $this->price = $price;
    }

    public function getPrice(): string
    {
        return $this->price;
    }

    public function setPrice(string $price): void
    {
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }



}
