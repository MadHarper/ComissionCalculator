<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

class WeekCashOutCollection
{
    /**
     * @var WeekCashOut[]
     */
    private $collection = [];

    public function getWeekSum(Transaction $transaction): Money
    {
        if ($this->match($transaction)) {
            return ($this->collection[$transaction->getUserId()])->getWeekSum();
        }

        return new Money(0, Money::EUR);
    }

    public function getWeekCount(Transaction $transaction): int
    {
        if ($this->match($transaction)) {
            return ($this->collection[$transaction->getUserId()])->getWeekCount();
        }

        return 0;
    }

    /**
     * search transaction history by week start.
     */
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
        if (!$transaction->hasCashOutType() || !$transaction->isNaturalPerson()) {
            return;
        }

        if ($this->match($transaction)) {
            $this->collection[$transaction->getUserId()]->add($transaction);
        } else {
            $this->collection[$transaction->getUserId()] = new WeekCashOut($transaction);
        }
    }
}
