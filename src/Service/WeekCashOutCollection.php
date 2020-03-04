<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use MadHarper\CommissionTask\Service\Converter\CurrencyConverterInterface;

class WeekCashOutCollection
{
    /**
     * @var WeekCashOut[]
     */
    private $collection = [];
    /**
     * @var CurrencyConverterInterface
     */
    private $converter;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function getByTransaction(Transaction $transaction): Money
    {
        if ($this->match($transaction)) {
            return ($this->collection[$transaction->getUserId()])->getWeekSum();
        }

        return new Money(0, Money::EUR);
    }

    // collection contains searching data by id and week start
    public function match(Transaction $transaction): bool
    {
        return isset($this->collection[$transaction->getUserId()]) && $this->isSameWeek($transaction);
    }

    private function isSameWeek(Transaction $transaction): bool
    {
        return ($this->collection[$transaction->getUserId()])->getStartOfWeekTimestamp()
            === $transaction->getStartOfWeekTimestamp();
    }

    public function add(Transaction $transaction)
    {
        if (!$transaction->hasCachOutType()) {
            return;
        }

        if ($this->match($transaction)) {
            //ToDo: добавить сумму
        }

        $this->collection[$transaction->getUserId()] = new WeekCashOut($transaction);
    }
}
