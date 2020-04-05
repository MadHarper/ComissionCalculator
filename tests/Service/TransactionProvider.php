<?php
declare(strict_types=1);

namespace MadHarper\CommissionTask\Tests\Service;

use  DateTimeImmutable;

class TransactionProvider
{
    public static function getTransactionsArray(): array
    {
        return [
            new DateTimeImmutable(),
        ];
    }
}