<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Calculator;

use MadHarper\CommissionTask\Service\TransactionCollection;

interface FeeCalculatorInterface
{
    public function calculate(TransactionCollection $transactionCollection);
}
