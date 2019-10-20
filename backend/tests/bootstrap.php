<?php

declare(strict_types = 1);

use Dotenv\Dotenv;
use UMA\DIC\Container;
use App\DI;


require_once __DIR__.'/../vendor/autoload.php';

if (file_exists(__DIR__.'/../.env')) {
    $dotenv = Dotenv::create(__DIR__.'/../');
    $dotenv->load();
}


$testingSettings = require __DIR__.'/../settings.php';
unset($testingSettings['settings']['doctrine']['connection']['path']);
$testingSettings['settings']['doctrine']['connection']['memory'] = true;


$cnt = new Container($testingSettings);

$cnt->register(new DI\Doctrine());
$cnt->register(new DI\Slim());
$cnt->register(new DI\Validator());
