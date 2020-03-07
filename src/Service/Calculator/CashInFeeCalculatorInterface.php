<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\Transaction;

interface CashInFeeCalculatorInterface
{
    public function calculateCashInFee(Transaction $transaction): Money;
}
