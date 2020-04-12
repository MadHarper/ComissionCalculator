<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\Service;

use DateTimeImmutable;
use Exception;
use InvalidArgumentException;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverterInterface;

class DataParser
{
    /**
     * @var CurrencyConverterInterface
     */
    private $converter;

    public function __construct(CurrencyConverterInterface $converter)
    {
        $this->converter = $converter;
    }

    public function parse(array $data): TransactionCollection
    {
        $collection = new TransactionCollection();

        try {
            foreach ($data as $line) {
                $date = new DateTimeImmutable($line[0]);
                $userId = (int) $line[1];
                $personType = $line[2];
                $operationType = $line[3];
                $money = new Money((float) $line[4], $line[5]);
                $euro = $this->converter->convert($money, Money::EUR);
                $transaction = new Transaction($date, $userId, $personType, $operationType, $money, $euro);
                $collection->add($transaction);
            }

            return $collection;
        } catch (Exception $exception) {
            throw new InvalidArgumentException('Wrong input data format');
        }
    }
}
