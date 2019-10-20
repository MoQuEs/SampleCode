<?php


namespace App\Tests\Unit\Handlers;


use App\Handlers\HttpErrorHandler;
use App\Tests\Stubs\CallableResolverInterfaceStub;
use App\Tests\Stubs\ResponseFactoryInterfaceStub;
use PHPUnit\Framework\TestCase;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpNotFoundException;
use Slim\Factory\ServerRequestCreatorFactory;


/**
 * Class HttpErrorHandlerTest
 * @package App\Tests\Unit\Handlers
 */
class HttpErrorHandlerTest extends TestCase {
    /**
     *
     */
    public function testHttpErrorHandler(): void {
        $request = ServerRequestCreatorFactory::create();
        $httpErrorHandler = new HttpErrorHandler(new CallableResolverInterfaceStub(), new ResponseFactoryInterfaceStub());

        $httpErrorHandler($request->createServerRequestFromGlobals(), new HttpBadRequestException($request->createServerRequestFromGlobals()), false, false, false);
        $json = $httpErrorHandler->jsonSerialize();
        self::assertIsArray($json);
        self::assertArrayHasKey('statusCode', $json);
        self::assertEquals(400, $json['statusCode']);


        $httpErrorHandler($request->createServerRequestFromGlobals(), new HttpNotFoundException($request->createServerRequestFromGlobals()), false, false, false);
        $json = $httpErrorHandler->jsonSerialize();
        self::assertIsArray($json);
        self::assertArrayHasKey('statusCode', $json);
        self::assertEquals(404, $json['statusCode']);
    }
}