<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use MadHarper\CommissionTask\Service\Converter\CurrencyConverterInterface;
use MadHarper\CommissionTask\Service\Transaction;
use MadHarper\CommissionTask\Service\WeekCashOutCollection;
use MadHarper\CommissionTask\Service\TransactionCollection;

class FeeCalculator implements FeeCalculatorInterface
{
    /**
     * @var WeekCashOutCollection
     */
    private $weekCashOutCollection;
    /**
     * @var CurrencyConverterInterface
     */
    private $converter;

    public function __construct(WeekCashOutCollection $weekCashOutCollection, CurrencyConverterInterface $converter)
    {
        $this->weekCashOutCollection = $weekCashOutCollection;
        $this->converter = $converter;
    }

    public function calculate(TransactionCollection $transactionCollection)
    {
        /** @var Transaction $transaction */
        foreach ($transactionCollection as $transaction) {

            echo $transaction->getMoney()->getPercent(0.033)->round() . PHP_EOL;
            $this->weekCashOutCollection->add($transaction);
        }
    }
}
