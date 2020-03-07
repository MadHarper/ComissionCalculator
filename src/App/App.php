<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\App;

use Exception;
use MadHarper\CommissionTask\Service\DataParser;
use MadHarper\CommissionTask\Service\Calculator\FeeCalculatorInterface;
use MadHarper\CommissionTask\Service\Transaction;

/**
 * Class App
 * Root class of application
 */
class App
{
    /**
     * @var DataReader
     */
    private $reader;
    /**
     * @var DataParser
     */
    private $dataParser;
    /**
     * @var FeeCalculatorInterface
     */
    private $feeCalculator;

    public function __construct(DataReader $reader, DataParser $dataParser, FeeCalculatorInterface $feeCalculator)
    {
        $this->reader = $reader;
        $this->dataParser = $dataParser;
        $this->feeCalculator = $feeCalculator;
    }

    public function run(array $args)
    {
//        $d = new \DateTimeImmutable('1970-01-01');
//        var_dump($d->format('w')); die;

//        $d = new \DateTimeImmutable('2020-02-23');
//        var_dump($d->modify('Monday this week')); die;








        try {
            $rawData = $this->reader->read($args);
            $data = $this->dataParser->parse($rawData);
            $this->feeCalculator->calculate($data);

            /** @var Transaction $d */
            foreach ($data as $d) {
                echo $d->getFee() . PHP_EOL;
            }

        } catch (Exception $exception) {
            exit($exception->getMessage() . PHP_EOL);
        }
    }
}