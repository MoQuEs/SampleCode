<?php

declare(strict_types = 1);

namespace App\DI;


use App\Handlers\HttpErrorHandler;
use App\Routes;
use Slim\App;
use Slim\Factory\AppFactory;
use Tuupola\Middleware\CorsMiddleware;
use UMA\DIC\Container;
use UMA\DIC\ServiceProvider;


/**
 * Class Slim
 * @package App\DI
 */
class Slim implements ServiceProvider {
    /**
     * @param Container $c
     */
    public function provide(Container $c): void {
        $c->set(App::class, static function (Container $c): App {
            $todoRoutes = new Routes\Todo($c);

            /** @var array $settings */
            $settings = $c->get('settings');

            $app = AppFactory::create(null, $c);
            $app->addBodyParsingMiddleware();

            $errorMiddleware = $app->addErrorMiddleware(
                $settings['slim']['displayErrorDetails'],
                $settings['slim']['logErrors'],
                $settings['slim']['logErrorDetails']
            );

            $httpErrorHandler = new HttpErrorHandler($app->getCallableResolver(), $app->getResponseFactory());
            $errorMiddleware->setDefaultErrorHandler($httpErrorHandler);

            $app->add(new CorsMiddleware([
                "origin" => ['*'],
                "methods" => ['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'],
                "headers.allow" => ['Content-Type'],
                "headers.expose" => [],
                "credentials" => false,
                "cache" => 0,
            ]));


            $todoRoutes($app);

            return $app;
        });
    }
}