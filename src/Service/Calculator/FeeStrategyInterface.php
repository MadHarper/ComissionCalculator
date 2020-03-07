<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\Transaction;

interface FeeStrategyInterface
{
    public function calculateFee(Transaction $transaction): Money;

    public function support(Transaction $transaction): bool;
}
