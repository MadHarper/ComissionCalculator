<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service\Converter;

use DomainException;
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
        $fromCurrency = $money->getCurrency();
        $this->check($fromCurrency);
        $this->check($toCurrency);
        $convertedAmount = $this->rates[$toCurrency] / $this->rates[$fromCurrency] * $money->getAmount();

        return new Money($convertedAmount, $toCurrency);
    }

    private function check(string $currency)
    {
        if (!array_key_exists($currency, $this->rates)) {
            throw new DomainException(sprintf('No currency rate for %s', $currency));
        }
    }

    /**
     *  Change current rate method.
     */
    public function setRate(string $currency, float $rate)
    {
        $this->rates[$currency] = $rate;
    }

    public function getRate(string $currency): float
    {
        $this->check($currency);

        return $this->rates[$currency];
    }
}
