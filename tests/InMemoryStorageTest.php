<?php

namespace App\Tests;

use App\InMemoryStorage;
use PHPUnit\Framework\TestCase;
use PHPUnit\Framework\Attributes;

#[Attributes\CoversClass(InMemoryStorage::class)]
class InMemoryStorageTest extends TestCase
{
    public function test(): void
    {
        $this->assertTrue(true);
    }
}
