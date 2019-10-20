<?php

declare(strict_types = 1);

namespace App\Tests\Functional;


use App\Action\Todo\ListTodo;
use App\Tests\Stubs\ResponseFactoryInterfaceStub;
use Nyholm\Psr7\Response;
use Nyholm\Psr7\Stream;
use Slim\Factory\ServerRequestCreatorFactory;
use App\Tests\Utils\EntityManagerTestCase;


/**
 * Class ActionsTest
 * @package App\Tests\Functional
 */
class ActionsTest extends EntityManagerTestCase {
    /**
     *
     */
    public function test_ListAllTodosAction(): void {
        $responseF = new ResponseFactoryInterfaceStub();
        $requestF = ServerRequestCreatorFactory::create();

        $stream = Stream::create('[]');
        $responseEnd = new Response(200, [
            'Content-Type' => 'application/json',
            'Content-Length' => $stream->getSize(),
        ], $stream, '1.1', 'OK');

        $listTodo = new ListTodo(self::$em);
        $response = $listTodo($requestF->createServerRequestFromGlobals(), $responseF->createResponse(200, ''), []);

        $responseEnd->getBody()->rewind();
        $response->getBody()->rewind();
        self::assertEquals($responseEnd->getBody()->getContents(), $response->getBody()->getContents());
    }
}
