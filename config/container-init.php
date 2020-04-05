<?php

declare(strict_types=1);

use DI\Container;
use MadHarper\CommissionTask\App\App;
use MadHarper\CommissionTask\App\DataReaderInterface;
use MadHarper\CommissionTask\App\CsvReader;
use MadHarper\CommissionTask\Service\Calculator\CashInFeeCalculatorInterface;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverter;
use MadHarper\CommissionTask\Service\DataParser;
use MadHarper\CommissionTask\Service\Calculator\FeeCalculator;
use MadHarper\CommissionTask\Service\Converter\CurrencyConverterInterface;
use MadHarper\CommissionTask\Service\Calculator\FeeCalculatorInterface;
use MadHarper\CommissionTask\Service\Money;
use MadHarper\CommissionTask\Service\WeekCashOutCollection;
use MadHarper\CommissionTask\Service\Calculator\CashInFeeCalculator;
use MadHarper\CommissionTask\Service\Calculator\CashOutFeeCalculatorInterface;
use MadHarper\CommissionTask\Service\Calculator\CashOutFeeCalculator;

return function(Container $container)
{
    $container->set(DataParser::class, function (Container $container){
        return new DataParser($container->get(CurrencyConverterInterface::class));
    });

    $container->set(DataReaderInterface::class, function (Container $container){
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
        return new WeekCashOutCollection();
    });

    $container->set(CashInFeeCalculatorInterface::class, function (Container $container){
        return new CashInFeeCalculator($container->get(CurrencyConverterInterface::class));
    });

    $container->set(CashOutFeeCalculatorInterface::class, function (Container $container){
        return new CashOutFeeCalculator($container->get(CurrencyConverterInterface::class));
    });

    $container->set(FeeCalculatorInterface::class, function (Container $container){
        return new FeeCalculator(
            $container->get(WeekCashOutCollection::class),
            $container->get(CashInFeeCalculatorInterface::class),
            $container->get(CashOutFeeCalculatorInterface::class)
        );
    });

    $container->set(App::class, function (Container $container){
        return new App(
            $container->get(DataReaderInterface::class),
            $container->get(DataParser::class),
            $container->get(FeeCalculatorInterface::class)
        );
    });
};
