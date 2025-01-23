<?php

namespace Tests;

use PHPUnit\Framework\TestCase;

class WalletTest extends TestCase
{
    public function testGetBalance()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $this->assertEquals(0, $wallet->getBalance());
    }

    public function testAddFund()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->addFund(100);
        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testAddFundException()
    {
        $this->expectException(\Exception::class);
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->addFund(-100);
    }

    public function testSetCurrency()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setCurrency('EUR');
        $this->assertEquals('EUR', $wallet->getCurrency());
    }

    public function testSetCurrencyException()
    {
        $this->expectException(\Exception::class);
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setCurrency('JPY');
    }

    public function testSetBalance()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setBalance(100);
        $this->assertEquals(100, $wallet->getBalance());
    }

    public function testSetBalanceException()
    {
        $this->expectException(\Exception::class);
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setBalance(-100);
    }

    public function testGetCurrency()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function test__construct()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $this->assertEquals(0, $wallet->getBalance());
        $this->assertEquals('USD', $wallet->getCurrency());
    }

    public function testRemoveFund()
    {
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->setBalance(100);
        $wallet->removeFund(50);
        $this->assertEquals(50, $wallet->getBalance());
    }

    public function testRemoveFundException()
    {
        $this->expectException(\Exception::class);
        $wallet = new \App\Entity\Wallet('USD');
        $wallet->removeFund(100);
    }
}
