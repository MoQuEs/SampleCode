<?php

declare(strict_types = 1);

use Dotenv\Dotenv;
use UMA\DIC\Container;


require_once __DIR__.'/vendor/autoload.php';

if (file_exists('.env')) {
    $dotenv = Dotenv::create(__DIR__);
    $dotenv->load();
}

return new Container(require __DIR__.'/settings.php');
