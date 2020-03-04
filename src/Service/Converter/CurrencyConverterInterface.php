<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Converter;

use MadHarper\CommissionTask\Service\Money;

interface CurrencyConverterInterface
{
    public function convert(Money $money, string $toCurrency): Money;

    public function setRate(string $currency, float $rate);
}
