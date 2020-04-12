<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use DomainException;
use MadHarper\CommissionTask\Service\Transaction;
use MadHarper\CommissionTask\Service\TransactionCollection;
use MadHarper\CommissionTask\Service\WeekCashOutCollection;

class FeeCalculator implements FeeCalculatorInterface
{
    /**
     * @var WeekCashOutCollection
     */
    private $weekCashOutCollection;
    /**
     * @var CashInFeeCalculatorInterface
     */
    private $cashInFeeCalculator;
    /**
     * @var CashOutFeeCalculatorInterface
     */
    private $cashOutFeeCalculator;

    public function __construct(
        WeekCashOutCollection $weekCashOutCollection,
        CashInFeeCalculatorInterface $cashInFeeCalculator,
        CashOutFeeCalculatorInterface $cashOutFeeCalculator
    ) {
        $this->weekCashOutCollection = $weekCashOutCollection;
        $this->cashInFeeCalculator = $cashInFeeCalculator;
        $this->cashOutFeeCalculator = $cashOutFeeCalculator;
    }

    public function calculate(TransactionCollection $transactionCollection)
    {
        /** @var Transaction $transaction */
        foreach ($transactionCollection as $transaction) {
            if (Transaction::CASH_IN_OPERATION_TYPE === $transaction->getOperationType()) {
                $fee = $this->cashInFeeCalculator->calculateCashInFee($transaction);
            } elseif (Transaction::CASH_OUT_OPERATION_TYPE === $transaction->getOperationType()) {
                $fee = $this->cashOutFeeCalculator->calculateCashOutFee($transaction, $this->weekCashOutCollection);
            } else {
                throw new DomainException('Undefined transaction type.');
            }

            $transaction->setFee($fee);
            $this->weekCashOutCollection->add($transaction);
        }
    }
}
