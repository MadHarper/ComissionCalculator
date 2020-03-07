<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use IteratorAggregate;
use ArrayIterator;

class TransactionCollection implements IteratorAggregate
{
    /** @var Transaction[] */
    private $transactions = [];

    public function getIterator()
    {
        return new ArrayIterator($this->transactions);
    }

    public function add(Transaction $transaction)
    {
        $this->transactions[] = $transaction;
    }
}
