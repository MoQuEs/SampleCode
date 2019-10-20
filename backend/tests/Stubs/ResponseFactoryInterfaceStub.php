<?php


namespace App\Tests\Stubs;


use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;


/**
 * Class ResponseFactoryInterfaceStub
 * @package App\Tests\Stubs
 */
class ResponseFactoryInterfaceStub implements ResponseFactoryInterface {
    /**
     * {@inheritDoc}
     */
    public function createResponse(int $code = 200, string $reasonPhrase = ''): ResponseInterface {
        return new Response($code, [], null, '1.1', $reasonPhrase);
    }
}