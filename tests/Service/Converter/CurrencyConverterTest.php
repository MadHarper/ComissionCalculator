<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Tests\Service\Converter;

use MadHarper\CommissionTask\Service\Converter\CurrencyConverter;
use MadHarper\CommissionTask\Service\Money;
use PHPUnit\Framework\TestCase;

class CurrencyConverterTest extends TestCase
{
    /**
     * @var CurrencyConverter
     */
    private $converter;

    public function setUp()
    {
        $rates = [
            Money::EUR => 1,
            Money::USD => 1.1497,
            Money::JPY => 129.53,
        ];

        $this->converter = new CurrencyConverter($rates);
    }

    public function testCurrencyToSameCurrency()
    {
        $amount = 5;
        $money = new Money($amount, Money::EUR);
        $convertedMoney = $this
            ->converter
            ->convert($money, Money::EUR);

        $this->assertEquals($convertedMoney->getAmount(), $money->getAmount());

        $money = new Money($amount, Money::USD);
        $convertedMoney = $this
            ->converter
            ->convert($money, Money::USD);

        $this->assertEquals($convertedMoney->getAmount(), $money->getAmount());

        $money = new Money($amount, Money::JPY);
        $convertedMoney = $this
            ->converter
            ->convert($money, Money::JPY);

        $this->assertEquals($convertedMoney->getAmount(), $money->getAmount());
    }

    /**
     * @dataProvider ratesProvider
     */
    public function testFromEuro($rateUsd, $rateJpy, $amount)
    {
        $this->converter->setRate(Money::USD, $rateUsd);
        $this->converter->setRate(Money::JPY, $rateJpy);

        $fromEuroToUsdExpected = $this->convert(
            1,
            $rateUsd,
            $amount
        );

        $euroMoney = new Money($amount, Money::EUR);
        $this->assertEquals(
            $fromEuroToUsdExpected,
            $this->converter->convert($euroMoney, Money::USD)->getAmount()
        );

        $fromEuroToJpyExpected = $this->convert(
            1,
            $rateJpy,
            $amount
        );
        $this->assertEquals(
            $fromEuroToJpyExpected,
            $this->converter->convert($euroMoney, Money::JPY)->getAmount()
        );
    }

    /**
     * @dataProvider ratesProvider
     */
    public function testToEuro($rateUsd, $rateJpy, $amount)
    {
        $this->converter->setRate(Money::USD, $rateUsd);
        $this->converter->setRate(Money::JPY, $rateJpy);

        $fromUsdToEurExpected = $this->convert(
            $rateUsd,
            1,
            $amount
        );

        $usdMoney = new Money($amount, Money::USD);
        $this->assertEquals(
            $fromUsdToEurExpected,
            $this->converter->convert($usdMoney, Money::EUR)->getAmount()
        );


        $fromJpyToEuroExpected = $this->convert(
            $rateJpy,
            1,
            $amount
        );
        $jpyMoney = new Money($amount, Money::JPY);
        $this->assertEquals(
            $fromJpyToEuroExpected,
            $this->converter->convert($jpyMoney, Money::EUR)->getAmount()
        );
    }

    public function ratesProvider()
    {
        return [
            [1.1497, 129.53, 125],
            [2, 480, 14],
            [.3567, .530, 33],
        ];
    }
    
    private function convert(float $fromCurrencyRate, float $toCurrencyRate, int $amount)
    {
        return $toCurrencyRate / $fromCurrencyRate * $amount;
    }
}