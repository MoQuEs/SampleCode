<?php


namespace App\Utils;


use JsonSerializable;
use Nyholm\Psr7\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;


/**
 * Class Response
 * @package App\Utils
 */
class Response {
    /**
     * @param int $code
     * @param StreamInterface $body
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function streamInterface(int $code, StreamInterface $body, ResponseInterface $response): ResponseInterface {
        return $response
            ->withStatus($code)
            ->withHeader('Content-Length', $body->getSize())
            ->withBody($body);
    }

    /**
     * @param int $code
     * @param JsonSerializable $body
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function json(int $code, JsonSerializable $body, ResponseInterface $response): ResponseInterface {
        $stream = Stream::create(json_encode($body));

        return $response
            ->withStatus($code)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $stream->getSize())
            ->withBody($stream);
    }

    /**
     * @param int $code
     * @param mixed $body
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function jsonMessage(int $code, $body, ResponseInterface $response): ResponseInterface {
        $stream = Stream::create(json_encode($body));

        return $response
            ->withStatus($code)
            ->withHeader('Content-Type', 'application/json')
            ->withHeader('Content-Length', $stream->getSize())
            ->withBody($stream);
    }

    /**
     * @param int $code
     * @param string $body
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function message(int $code, string $body, ResponseInterface $response): ResponseInterface {
        $stream = Stream::create($body);

        return $response
            ->withStatus($code)
            ->withHeader('Content-Length', $stream->getSize())
            ->withBody($stream);
    }

    /**
     * @param int $code
     * @param ResponseInterface $response
     * @return ResponseInterface
     */
    public static function code(int $code, ResponseInterface $response): ResponseInterface {
        return $response->withStatus($code);
    }
}