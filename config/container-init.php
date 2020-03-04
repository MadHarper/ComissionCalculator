<?php

declare(strict_types=1);

use DI\Container;
use MadHarper\CommissionTask\App\App;
use MadHarper\CommissionTask\App\DataReader;
use MadHarper\CommissionTask\App\CsvReader;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverter;
use MadHarper\CommissionTask\Service\DataParser;
use MadHarper\CommissionTask\Service\Calculator\FeeCalculator;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverterInterface;
use MadHarper\CommissionTask\Service\Calculator\FeeCalculatorInterface;
use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\WeekCashOutCollection;

return function(Container $container)
{
    $container->set(DataParser::class, function (Container $container){
        return new DataParser();
    });

    $container->set(DataReader::class, function (Container $container){
        return new CsvReader($container->get('root'));
    });

    $container->set(
        'rates',
        [
            Money::EUR => 1,
            Money::USD => 1.1497,
            Money::JPY => 129.53,
        ]
    );

    $container->set(CurrencyConverterInterface::class, function (Container $container){
        return new CurrencyConverter($container->get('rates'));
    });

    $container->set(WeekCashOutCollection::class, function (Container $container){
        return new WeekCashOutCollection($container->get(CurrencyConverterInterface::class));
    });

    $container->set(FeeCalculatorInterface::class, function (Container $container){
        return new FeeCalculator(
            $container->get(WeekCashOutCollection::class),
            $container->get(CurrencyConverterInterface::class)
        );
    });

    $container->set(App::class, function (Container $container){
        return new App(
            $container->get(DataReader::class),
            $container->get(DataParser::class),
            $container->get(FeeCalculatorInterface::class)
        );
    });

};
