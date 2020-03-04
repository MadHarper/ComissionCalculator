<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use DomainException;

class Money
{
    const EUR = 'EUR';
    const USD = 'USD';
    const JPY = 'JPY';

    /**
     * @var float
     */
    private $amount;
    /**
     * @var string
     */
    private $currency;

    public function __construct(float $amount, string $currency)
    {
        $this->amount = $amount;
        $this->currency = $currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function add(Money $money)
    {
        //Todo: вернуть клон
        
    }

    public function getPercent(float $percent): self
    {
        $result = clone($this);
        $result->amount = $this->amount / 100 * $percent;

        return $result;
    }

    public function round(): self
    {
        $fact = 10 ** $this->getPrecision();
        $roundedAmount = ceil($fact * $this->amount) / $fact;
        $result = clone($this);
        $result->amount = $roundedAmount;

        return $result;
    }

    public function getPrecision(): int
    {
        switch ($this->getCurrency()) {
            case self::EUR :
                return 2;
            case self::USD :
                return 2;
            case self::JPY:
                return 0;
            default:
                throw new DomainException('Money currency has unsupported value');
        }
    }
    //Todo:
    public function __toString(): string
    {
        return number_format($this->getAmount(), $this->getPrecision(), '.', '');
    }
}
