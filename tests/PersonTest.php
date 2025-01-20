<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class PersonTest extends TestCase
{
    /**
     * Test the person class.
     * It also tests the getter methods.
     * @return void
     */
    public function testPerson(): void
    {
        $person = new \App\Entity\Person('John Doe', 'USD');
        $this->assertEquals('John Doe', $person->getName());
        $this->assertInstanceOf(\App\Entity\Wallet::class, $person->getWallet());
        $this->assertEquals('USD', $person->getWallet()->getCurrency());
    }

    /**
     * Test the person name setter.
     * @return void
     */
    public function testSetPersonName(): void
    {
        $person = new \App\Entity\Person('John Doe', 'USD');
        $person->setName('Jane Doe');
        $this->assertEquals('Jane Doe', $person->getName());
    }

    /**
     * Test the person wallet setter.
     * @return void
     */
    public function testSetPersonWallet(): void
    {
        $person = new \App\Entity\Person('John Doe', 'USD');
        $wallet = new \App\Entity\Wallet('EUR');
        $person->setWallet($wallet);
        $this->assertEquals($wallet, $person->getWallet());
    }

    /**
     * Test the hasFund method return true when the person has fund.
     * @return void
     */
    public function testPersonHasFund() : void
    {
        $person = new \App\Entity\Person('John Doe', 'USD');
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setBalance(100);
        $person->setWallet($wallet);
        $this->assertTrue($person->hasFund());
    }

    /**
     * Test the hasFund method return false when the person has no fund.
     * @return void
     */
    public function testPersonHasNoFund() : void
    {
        $person = new \App\Entity\Person('John Doe', 'USD');
        $this->assertFalse($person->hasFund());
    }

    /**
     * Test the transfertFund method when the wallet currency is different from the person's wallet currency.
     * The method should throw an exception.
     * @return void
     * @throws \Exception
     */
    public function testPersonTransfertFundWithDifferentCurrency() : void
    {
        $person1 = new \App\Entity\Person('John Doe', 'USD');
        $wallet1 = new \App\Entity\Wallet('USD');
        $wallet1->setBalance(100);
        $person1->setWallet($wallet1);

        $person2 = new \App\Entity\Person('Jane Doe', 'EUR');
        $wallet2 = new \App\Entity\Wallet('EUR');
        $wallet2->setBalance(100);
        $person2->setWallet($wallet2);

        $this->expectException(\Exception::class);
        $person1->transfertFund(50, $person2);
    }

    /**
     * Test the transfertFund method when the person has insufficient fund.
     * @return void
     * @throws \Exception
     */
    public function testPersonTransfertFundWithInsufficientFund() : void
    {
        $person1 = new \App\Entity\Person('John Doe', 'USD');
        $wallet1 = new \App\Entity\Wallet('USD');
        $wallet1->setBalance(100);
        $person1->setWallet($wallet1);

        $person2 = new \App\Entity\Person('Jane Doe', 'USD');
        $wallet2 = new \App\Entity\Wallet('USD');
        $wallet2->setBalance(100);
        $person2->setWallet($wallet2);

        $this->expectException(\Exception::class);
        $person1->transfertFund(150, $person2);
    }

    /**
     * Test the transfertFund method when the amount is invalid.
     * @return void
     * @throws \Exception
     */
    public function testPersonTransfertFundWithInvalidAmount() : void
    {
        $person1 = new \App\Entity\Person('John Doe', 'USD');
        $wallet1 = new \App\Entity\Wallet('USD');
        $wallet1->setBalance(100);
        $person1->setWallet($wallet1);

        $person2 = new \App\Entity\Person('Jane Doe', 'USD');
        $wallet2 = new \App\Entity\Wallet('USD');
        $wallet2->setBalance(100);
        $person2->setWallet($wallet2);

        $this->expectException(\Exception::class);
        $person1->transfertFund(-50, $person2);
    }

    /**
     * Test the transfertFund method when the wallet currency is the same as the person's wallet currency.
     * @return void
     * @throws \Exception
     */
    public function testPersonTransfertFund() : void
    {
        $person1 = new \App\Entity\Person('John Doe', 'USD');
        $wallet1 = new \App\Entity\Wallet('USD');
        $wallet1->setBalance(100);
        $person1->setWallet($wallet1);

        $person2 = new \App\Entity\Person('Jane Doe', 'USD');
        $wallet2 = new \App\Entity\Wallet('USD');
        $wallet2->setBalance(100);
        $person2->setWallet($wallet2);

        $person1->transfertFund(50, $person2);
        $this->assertEquals(50, $person1->getWallet()->getBalance());
        $this->assertEquals(150, $person2->getWallet()->getBalance());
    }

    // TODO: Add tests for the divideWallet method

    /**
     * Test the buyProduct method.
     * @return void
     * @throws \Exception
     */
    public function testPersonBuyProduct() : void
    {
        $person = new \App\Entity\Person('John Doe', 'USD');
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setBalance(100);
        $person->setWallet($wallet);

        $product = new \App\Entity\Product('Product 1', 50);

        $person->buyProduct($product);
        $this->assertEquals(50, $person->getWallet()->getBalance());
    }
}
