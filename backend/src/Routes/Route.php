<?php

declare(strict_types = 1);

namespace App\Routes;


use Slim\App;
use UMA\DIC\Container;


/**
 * Class Route
 * @package App\Routes
 */
abstract class Route {
    /** @var Container $c */
    protected $c;

    /**
     * Route constructor.
     * @param Container $c
     */
    public function __construct(Container $c) {
        $this->c = $c;
        $this->setContainers($this->c);
    }

    /**
     * @param Container $c
     */
    abstract protected function setContainers(Container $c): void;

    /**
     * @param App $app
     */
    abstract public function __invoke(App $app): void;
}