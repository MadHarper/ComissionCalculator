<?php

declare(strict_types=1);

namespace MadHarper\CommissionTask\App;

interface DataReader
{
    public function read(array $args): array;
}