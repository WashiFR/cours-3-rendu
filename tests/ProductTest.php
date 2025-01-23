<?php

namespace Tests;

use App\Entity\Product;
use App\Entity\Wallet;
use Exception;
use PHPUnit\Framework\TestCase;

class ProductTest extends TestCase
{
    public function testCanSetAndGetName()
    {
        $product = new Product("Laptop", ["USD" => 1000], "tech");
        $this->assertEquals("Laptop", $product->getName());
    }

    public function testCanSetAndGetPrices()
    {
        $prices = ["USD" => 1000, "EUR" => 900];
        $product = new Product("Laptop", $prices, "tech");
        $this->assertEquals($prices, $product->getPrices());
    }

    public function testCanSetAndGetType()
    {
        $product = new Product("Laptop", ["USD" => 1000], "tech");
        $this->assertEquals("tech", $product->getType());
    }

    public function testInvalidProductTypeThrowsException()
    {
        $this->expectException(Exception::class);
        new Product("Laptop", ["USD" => 1000], "invalidType");
    }

    public function testGetTVAForFood()
    {
        $product = new Product("Apple", ["USD" => 1], "food");
        $this->assertEquals(0.1, $product->getTVA());
    }

    public function testGetTVAForNonFood()
    {
        $product = new Product("Laptop", ["USD" => 1000], "tech");
        $this->assertEquals(0.2, $product->getTVA());
    }

    public function testListCurrencies()
    {
        $prices = ["USD" => 1000, "EUR" => 900];
        $product = new Product("Laptop", $prices, "tech");
        $this->assertEquals(["USD", "EUR"], $product->listCurrencies());
    }

    public function testGetPriceValidCurrency()
    {
        $product = new Product("Laptop", ["USD" => 1000, "EUR" => 900], "tech");
        $this->assertEquals(1000, $product->getPrice("USD"));
    }

    public function testGetPriceInvalidCurrencyThrowsException()
    {
        $this->expectException(Exception::class);
        $product = new Product("Laptop", ["USD" => 1000, "EUR" => 900], "tech");
        $product->getPrice("GBP");
    }
}
