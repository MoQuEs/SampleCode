<?php
declare(strict_types = 1);

namespace App\Handlers;


use Exception;
use JsonSerializable;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Exception\HttpBadRequestException;
use Slim\Exception\HttpException;
use Slim\Exception\HttpForbiddenException;
use Slim\Exception\HttpMethodNotAllowedException;
use Slim\Exception\HttpNotFoundException;
use Slim\Exception\HttpNotImplementedException;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Handlers\ErrorHandler as SlimErrorHandler;
use Throwable;


/**
 * Class HttpErrorHandler
 * @package App\Handlers
 */
class HttpErrorHandler extends SlimErrorHandler implements JsonSerializable {
    public const BAD_REQUEST = 'BAD_REQUEST';
    public const INSUFFICIENT_PRIVILEGES = 'INSUFFICIENT_PRIVILEGES';
    public const NOT_ALLOWED = 'NOT_ALLOWED';
    public const NOT_IMPLEMENTED = 'NOT_IMPLEMENTED';
    public const RESOURCE_NOT_FOUND = 'RESOURCE_NOT_FOUND';
    public const SERVER_ERROR = 'SERVER_ERROR';
    public const UNAUTHENTICATED = 'UNAUTHENTICATED';

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string
     */
    protected $type;

    /**
     * @var string
     */
    protected $description;

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        $description = json_decode($this->getDescription());
        return [
            'statusCode' => $this->getStatusCode(),
            'error' => [
                'type' => $this->getType(),
                'description' => $description !== null ? $description : $this->getDescription(),
            ]
        ];
    }

    /**
     * @return  string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @var string
     */
    public function setDescription(string $description): void {
        $this->description = $description;
    }

    /**
     * @return  int
     */
    public function getStatusCode(): int {
        return $this->statusCode;
    }

    /**
     * @var int
     */
    public function setStatusCode(int $statusCode): void {
        $this->statusCode = $statusCode;
    }

    /**
     * @return  string
     */
    public function getType(): string {
        return $this->type;
    }

    /**
     * @var string
     */
    public function setType(string $type): void {
        $this->type = $type;
    }

    /**
     * @inheritdoc
     */
    protected function respond(): Response {
        $exception = $this->exception;
        $this->errorSetup();

        if ($exception instanceof HttpException) {
            $this->statusCode = $exception->getCode();
            $this->setDescription($exception->getMessage());

            if ($exception instanceof HttpNotFoundException) {
                $this->setType(self::RESOURCE_NOT_FOUND);
            } elseif ($exception instanceof HttpMethodNotAllowedException) {
                $this->setType(self::NOT_ALLOWED);
            } elseif ($exception instanceof HttpUnauthorizedException) {
                $this->setType(self::UNAUTHENTICATED);
            } elseif ($exception instanceof HttpForbiddenException) {
                $this->setType(self::INSUFFICIENT_PRIVILEGES);
            } elseif ($exception instanceof HttpBadRequestException) {
                $this->setType(self::BAD_REQUEST);
            } elseif ($exception instanceof HttpNotImplementedException) {
                $this->setType(self::NOT_IMPLEMENTED);
            }

        } elseif (($exception instanceof Exception || $exception instanceof Throwable) && $this->displayErrorDetails) {
            $this->setDescription($exception->getMessage());
        }

        $encodedPayload = json_encode($this, JSON_PRETTY_PRINT);
        $response = $this->responseFactory->createResponse($this->getStatusCode());
        $response->getBody()->write($encodedPayload);

        return $response->withHeader('Content-Type', 'application/json');
    }

    /**
     * @var string
     */
    public function errorSetup(): void {
        $this->setStatusCode(500);
        $this->setType(self::SERVER_ERROR);
        $this->setDescription('');
    }
}
