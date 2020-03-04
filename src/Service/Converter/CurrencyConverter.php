<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Converter;

use MadHarper\CommissionTask\Service\Money;

class CurrencyConverter implements CurrencyConverterInterface
{
    private $rates;

    public function __construct(array $rates)
    {
        $this->rates = $rates;
    }

    public function convert(Money $money, string $toCurrency): Money
    {
        // TODO: Implement convert() method.
    }

    /**
     *  Change current rate method
     *
     * @param string $currency
     * @param float $rate
     */
    public function setRate(string $currency, float $rate)
    {
        $this->rates[$currency] = $rate;
    }
}
