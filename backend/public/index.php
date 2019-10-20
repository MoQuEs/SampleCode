<?php

declare(strict_types = 1);

use App\DI\Doctrine;
use App\DI\Slim;
use App\DI\Validator;
use Slim\App;
use UMA\DIC\Container;


/** @var Container $cnt */
$cnt = require_once __DIR__.'/../bootstrap.php';


$cnt->register(new Doctrine());
$cnt->register(new Validator());
$cnt->register(new Slim());

/** @var App $app */
$app = $cnt->get(App::class);

$app->run();
