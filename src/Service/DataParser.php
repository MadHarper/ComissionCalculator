<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use DateTimeImmutable;
use InvalidArgumentException;

class DataParser
{
    public function parse(array $data): TransactionCollection
    {
        $collection = new TransactionCollection();

        try {
            foreach ($data as $line) {
                $date = new DateTimeImmutable($line[0]);
                $userId = (int)$line[1];
                $personType = $line[2];
                $operationType = $line[3];
                $currency = new Money((float)$line[4], $line[5]);
                $transaction = new Transaction($date, $userId, $personType, $operationType, $currency);
                $collection->add($transaction);
            }

            return $collection;
        } catch (\Exception $exception) {
            throw new InvalidArgumentException('Wrong input data format');
        }
    }
}
