<?php

declare(strict_types = 1);

namespace App\DI;


use Awurth\SlimValidation\Validator as V;
use UMA\DIC\Container;
use UMA\DIC\ServiceProvider;


/**
 * Class Validator
 * @package App\DI
 */
class Validator implements ServiceProvider {
    /**
     * @param Container $c
     */
    public function provide(Container $c): void {
        $c->set(V::class, static function (Container $c): V {
            return new V();
        });
    }
}
