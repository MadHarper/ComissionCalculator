<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\Transaction;
use MadHarper\CommissionTask\Service\WeekCashOutCollection;

interface CashOutFeeCalculatorInterface
{
    public function calculateCashOutFee(Transaction $transaction, WeekCashOutCollection $weekCashOutCollection): Money;
}
