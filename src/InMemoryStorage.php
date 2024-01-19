<?php

namespace App;

class InMemoryStorage
{
    private array $storage = [];

    public function setValue(string $name, float $price): void
    {
        if (array_key_exists($name, $this->storage) === true) {
            $this->storage[$name] += $price;

            return;
        }

        $this->storage[$name] = $price;
    }

    public function restore(string $name): void
    {
        if (!array_key_exists($name, $this->storage)) {
            throw new \Exception("Product $name not found");
        }

        unset($this->storage[$name]);
    }

    public function reset(): void
    {
        $this->storage = [];
    }

    public function total(): float
    {
        return $this->storage->total();
    }

    public function getStorage(): array
    {
        return $this->storage;
    }
}
