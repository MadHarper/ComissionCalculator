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

    public function __construct(Transaction $transaction)
    {
        $this->weekSum = $transaction->getMoney();
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

    // Todo: pubf add()
}
