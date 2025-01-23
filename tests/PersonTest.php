<?php

namespace Tests;

use App\Entity\Person;
use App\Entity\Product;
use App\Entity\Wallet;
use Exception;
use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    public function testCanSetAndGetName()
    {
        $person = new Person("John", "USD");
        $this->assertEquals("John", $person->getName());
    }

    public function testCanSetAndGetWallet()
    {
        $person = new Person("John", "USD");
        $wallet = new Wallet("USD");
        $wallet->addFund(100);
        $person->setWallet($wallet);

        $this->assertSame($wallet, $person->getWallet());
        $this->assertEquals(100, $person->getWallet()->getBalance());
    }

    public function testHasFund()
    {
        $person = new Person("John", "USD");
        $this->assertFalse($person->hasFund());

        $person->getWallet()->addFund(50);
        $this->assertTrue($person->hasFund());
    }

    public function testTransfertFund()
    {
        $person1 = new Person("Alice", "USD");
        $person2 = new Person("Bob", "USD");
        $person1->getWallet()->addFund(100);

        $person1->transfertFund(50, $person2);

        $this->assertEquals(50, $person1->getWallet()->getBalance());
        $this->assertEquals(50, $person2->getWallet()->getBalance());
    }

    public function testTransfertFundDifferentCurrencies()
    {
        $this->expectException(Exception::class);
        $person1 = new Person("Alice", "USD");
        $person2 = new Person("Bob", "EUR");
        $person1->transfertFund(50, $person2);
    }

    public function testDivideWallet()
    {
        $person1 = new Person("Alice", "USD");
        $person2 = new Person("Bob", "USD");
        $person3 = new Person("Charlie", "USD");
        $person1->getWallet()->addFund(90);

        $person1->divideWallet([$person2, $person3]);

        $this->assertEquals(45, $person2->getWallet()->getBalance());
        $this->assertEquals(45, $person3->getWallet()->getBalance());
        $this->assertEquals(0, $person1->getWallet()->getBalance());
    }

    public function testBuyProduct()
    {
        $person = new Person("Alice", "USD");
        $product = $this->createMock(Product::class);
        $product->method('listCurrencies')->willReturn(["USD"]);
        $product->method('getPrice')->with("USD")->willReturn(30);

        $person->getWallet()->addFund(50);
        $person->buyProduct($product);

        $this->assertEquals(20, $person->getWallet()->getBalance());
    }

    public function testBuyProductWithDifferentCurrency()
    {
        $this->expectException(Exception::class);
        $person = new Person("Alice", "USD");
        $product = $this->createMock(Product::class);
        $product->method('listCurrencies')->willReturn(["EUR"]);

        $person->buyProduct($product);
    }

    public function testBuyProductWithoutEnoughFunds()
    {
        $this->expectException(Exception::class);
        $person = new Person("Alice", "USD");
        $product = $this->createMock(Product::class);
        $product->method('listCurrencies')->willReturn(["USD"]);
        $product->method('getPrice')->with("USD")->willReturn(100);

        $person->getWallet()->addFund(50);
        $person->buyProduct($product);
    }
}
