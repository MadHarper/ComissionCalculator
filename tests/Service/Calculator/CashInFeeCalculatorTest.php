<?php
declare(strict_types=1);

namespace MadHarper\CommissionTask\Tests\Service\Calculator;

use MadHarper\CommissionTask\Service\Calculator\CashInFeeCalculator;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverter;
use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\Transaction;
use PHPUnit\Framework\TestCase;
use DateTimeImmutable;

class CashInFeeCalculatorTest extends TestCase
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

    public function testLessCashInMaxAmount()
    {
        $amount = 4;
        $money = new Money($amount, Money::USD);
        $euro = $this->converter->convert($money, Money::EUR)->round();

        $transaction = new Transaction(
            new DateTimeImmutable(),
            1,
            Transaction::LEGAL_PERSON_TYPE,
            Transaction::CASH_IN_OPERATION_TYPE,
            $money,
            $euro
        );

        $cashInFeeCalculator = new CashInFeeCalculator($this->converter);
        $fee = $cashInFeeCalculator->calculateCashInFee($transaction);

        $expectedFee = $money
            ->getPercent(CashInFeeCalculator::CASH_IN_FEE)
            ->round();

        $feeEuro = $this->converter->convert($expectedFee, Money::EUR);
        $this->assertLessThan(CashInFeeCalculator::CASH_IN_FEE_MAX_AMOUNT, $feeEuro->getAmount());
        $this->assertTrue($fee->equal($expectedFee));
    }

    public function testGreaterCashInMaxAmount()
    {
        $amount = 40000;
        $money = new Money($amount, Money::USD);
        $euro = $this->converter->convert($money, Money::EUR)->round();

        $transaction = new Transaction(
            new DateTimeImmutable(),
            1,
            Transaction::LEGAL_PERSON_TYPE,
            Transaction::CASH_IN_OPERATION_TYPE,
            $money,
            $euro
        );

        $cashInFeeCalculator = new CashInFeeCalculator($this->converter);
        $fee = $cashInFeeCalculator->calculateCashInFee($transaction);

        $expectedFeeEuro = new Money(CashInFeeCalculator::CASH_IN_FEE_MAX_AMOUNT, Money::EUR);
        $expectedFee = $this
            ->converter
            ->convert($expectedFeeEuro, $money->getCurrency())
            ->round();

        $this->assertTrue($fee->equal($expectedFee));
    }
}