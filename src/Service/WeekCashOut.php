<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use DateTimeImmutable;

class WeekCashOut
{
    /**
     * @var Money
     */
    private $weekSum;
    /**
     * @var DateTimeImmutable
     */
    private $startOfWeek;
    /**
     * @var int
     */
    private $count = 1;

    public function __construct(Transaction $transaction)
    {
        $this->weekSum = $transaction->getEuro();
        $this->startOfWeek = $transaction->getStartOfWeek();
    }

    public function getStartOfWeek(): DateTimeImmutable
    {
        return $this->startOfWeek;
    }

    public function getStartOfWeekTimestamp(): int
    {
        return $this->getStartOfWeek()->getTimestamp();
    }

    public function isSameWeek(Transaction $transaction): bool
    {
        return $transaction->getStartOfWeek()->getTimestamp() === $this->startOfWeek->getTimestamp();
    }

    public function getWeekSum(): Money
    {
        return $this->weekSum;
    }

    public function getWeekCount(): int
    {
        return $this->count;
    }

    public function add(Transaction $transaction)
    {
        $this->weekSum = $this->weekSum->add($transaction->getEuro());
        ++$this->count;
    }
}
