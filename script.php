<?php

declare(strict_types=1);

use DI\Container;
use MadHarper\CommissionTask\App\App;

chdir(dirname(__DIR__));
require 'vendor/autoload.php';

// -------------- Container
/** @var Container $container */
$container = new Container();
$container->set('root', __DIR__);
(require 'config/container-init.php')($container);
// ----------------

$app = $container->get(App::class);
$app->run($argv);