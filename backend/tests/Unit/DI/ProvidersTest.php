<?php

declare(strict_types = 1);

namespace App\Tests\Unit;


use Doctrine\ORM\EntityManager;
use PHPUnit\Framework\TestCase;
use Awurth\SlimValidation\Validator as V;
use Slim\App;
use UMA\DIC\Container;
use App\DI;


/**
 * Class ProvidersTest
 * @package App\Tests\Unit
 */
class ProvidersTest extends TestCase {
    /**
     *
     */
    public function testContainer(): void {
        $sut = new Container($GLOBALS['testingSettings']);

        $sut->register(new DI\Slim());
        $sut->register(new DI\Doctrine());
        $sut->register(new DI\Validator());

        self::assertInstanceOf(App::class, $sut->get(App::class));
        self::assertInstanceOf(EntityManager::class, $sut->get(EntityManager::class));
        self::assertInstanceOf(V::class, $sut->get(V::class));
    }
}
