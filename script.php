<?php

declare(strict_types=1);

use MadHarper\CommissionTask\App\CsvRequest;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

try {

} catch (\Exception $exception) {
    exit($exception->getMessage());
}
$csvRequest = new CsvRequest();
$data = $csvRequest($argv);
var_dump($data);