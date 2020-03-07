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