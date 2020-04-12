<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use DomainException;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverterInterface;
use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\Transaction;
use MadHarper\CommissionTask\Service\WeekCashOutCollection;

class CashOutFeeCalculator implements CashOutFeeCalculatorInterface
{
    const CURRENCY = Money::EUR;

    const CASH_OUT_LEGAL_FEE = .3;
    const CASH_OUT_LEGAL_FEE_MIN_AMOUNT = .5;

    const CASH_OUT_NATURAL_WEEK_FREE = 1000;
    const CASH_OUT_WEEK_DISCOUNT_COUNT = 3;
    const CASH_OUT_DEFAULT_FEE_PERCENTS = .3;

    private $converter;

    private $legalMinFeeMoney;

    private $naturalWeekFreeMoney;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
        $this->legalMinFeeMoney = new Money(self::CASH_OUT_LEGAL_FEE_MIN_AMOUNT, self::CURRENCY);
        $this->naturalWeekFreeMoney = new Money(self::CASH_OUT_NATURAL_WEEK_FREE, self::CURRENCY);
    }

    public function calculateCashOutFee(Transaction $transaction, WeekCashOutCollection $weekCashOutCollection): Money
    {
        if (Transaction::LEGAL_PERSON_TYPE === $transaction->getUserType()) {
            return $this->calculateLegal($transaction);
        }

        if (Transaction::NATURAL_PERSON_TYPE === $transaction->getUserType()) {
            return $this->calculateNatural($transaction, $weekCashOutCollection);
        }

        throw new DomainException('Unknown operation type');
    }

    private function calculateLegal(Transaction $transaction): Money
    {
        $money = $transaction->getMoney();
        $percents = $money
            ->getPercent(self::CASH_OUT_LEGAL_FEE)
            ->round();

        $minimalFee = $this
            ->converter
            ->convert($this->legalMinFeeMoney, $money->getCurrency())
            ->round();

        return $percents->lessThan($minimalFee) ? $minimalFee : $percents;
    }

    private function calculateNatural(Transaction $transaction, WeekCashOutCollection $weekCashOutCollection): Money
    {
        $money = $transaction->getMoney();
        $moneyEuro = $transaction->getEuro();

        if ($weekCashOutCollection->getWeekCount($transaction) > self::CASH_OUT_WEEK_DISCOUNT_COUNT) {
            return $money
                ->getPercent(self::CASH_OUT_DEFAULT_FEE_PERCENTS)
                ->round();
        }

        $weekSumEuro = $weekCashOutCollection->getWeekSum($transaction);
        $newWeekSumEuro = $moneyEuro->add($weekSumEuro);

        $excess = $weekSumEuro->lessOrEqual($this->naturalWeekFreeMoney) ?
            $newWeekSumEuro->subtract($this->naturalWeekFreeMoney) :
            $moneyEuro;

        if ($excess->getAmount() <= 0) {
            return new Money(0, $money->getCurrency());
        }

        $fee = $excess->getPercent(self::CASH_OUT_DEFAULT_FEE_PERCENTS);

        return $this
            ->converter
            ->convert($fee, $money->getCurrency())
            ->round();
    }
}
