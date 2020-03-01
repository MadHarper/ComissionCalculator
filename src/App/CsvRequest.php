<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\App;

class CsvRequest
{
    public function __invoke(array $arg)
    {
        return $arg[0];
    }
}
