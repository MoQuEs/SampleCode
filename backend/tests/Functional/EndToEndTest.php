<?php

declare(strict_types = 1);

namespace App\Tests\Functional;


use App\Tests\Utils\EntityManagerTestCase;
use Nyholm\Psr7\ServerRequest;
use Psr\Http\Message\ResponseInterface;


/**
 * Class EndToEndTest
 * @package App\Tests\Functional
 */
class EndToEndTest extends EntityManagerTestCase {
    /**
     *
     */
    public function test_SeveralApiCalls(): void {
        $todos = json_decode((string)$this->test_GettingAListOfTodosWithTheGetEndpoint()->getBody());
        self::assertCount(0, $todos);

        $this->test_CreatingATodoWithThePutEndpoint();

        $todos = json_decode((string)$this->test_GettingAListOfTodosWithTheGetEndpoint()->getBody());
        self::assertCount(1, $todos);
        self::assertEquals('todo 1 description', $todos[0]->description);

        $this->test_EditATodoWithThePostEndpoint();

        $todos = json_decode((string)$this->test_GettingAListOfTodosWithTheGetEndpoint()->getBody());
        self::assertCount(1, $todos);
        self::assertEquals('todo 1 description EDIT', $todos[0]->description);

        $this->test_DeleteATodoWithTheDeleteEndpoint();

        $todos = json_decode((string)$this->test_GettingAListOfTodosWithTheGetEndpoint()->getBody());
        self::assertCount(0, $todos);
    }

    /**
     * @return ResponseInterface
     */
    public function test_GettingAListOfTodosWithTheGetEndpoint(): ResponseInterface {
        $request = new ServerRequest('GET', '/todo');
        $response = self::$app->handle($request);

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));

        return $response;
    }

    /**
     *
     */
    public function test_CreatingATodoWithThePutEndpoint(): void {
        $request = new ServerRequest(
            'PUT',
            '/todo',
            ['Content-Type' => 'application/json'],
            '{"subject": "todo 1", "description": "todo 1 description", "completed": false}'
        );
        $response = self::$app->handle($request);

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));
    }

    /**
     *
     */
    public function test_EditATodoWithThePostEndpoint(): void {
        $request = new ServerRequest(
            'POST',
            '/todo',
            ['Content-Type' => 'application/json'],
            '{"id": 1, "subject": "todo 1", "description": "todo 1 description EDIT", "completed": false}'
        );
        $response = self::$app->handle($request);

        self::assertSame(200, $response->getStatusCode());
        self::assertArrayHasKey('Content-Type', $response->getHeaders());
        self::assertStringStartsWith('application/json', $response->getHeaderLine('Content-Type'));
    }

    /**
     *
     */
    public function test_DeleteATodoWithTheDeleteEndpoint(): void {
        $request = new ServerRequest(
            'DELETE',
            '/todo/1'
        );
        $response = self::$app->handle($request);

        self::assertSame(204, $response->getStatusCode());
    }
}
