<?php

namespace MadHarper\CommissionTask\Service\Calculator;

use MadHarper\CommissionTask\Service\TransactionCollection;

interface FeeCalculatorInterface
{
    public function calculate(TransactionCollection $transactionCollection);
}