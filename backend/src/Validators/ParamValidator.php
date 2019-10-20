<?php

declare(strict_types = 1);

namespace App\Validators;


use Awurth\SlimValidation\Validator as V;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Exception\HttpBadRequestException;
use UMA\DIC\Container;


/**
 * Class RouteValidator
 * @package App\Validators
 */
abstract class ParamValidator {
    /** @var Container $c */
    protected $c;

    /**
     * ParamValidator constructor.
     * @param Container $c
     */
    public function __construct(Container $c) {
        $this->c = $c;
    }

    /**
     * @param Request $request
     * @param RequestHandler $handler
     * @return ResponseInterface
     * @throws HttpBadRequestException
     */
    public function __invoke(Request $request, RequestHandler $handler): ResponseInterface {
        /** @var V $validator */
        $validatorC = $this->c->get(V::class);
        $validator = $this->validate($validatorC, $request);

        if ($validator->isValid()) {
            return $handler->handle($request);
        }

        throw new HttpBadRequestException($request, json_encode($validator->getErrors()));
    }

    /**
     * @param V $validator
     * @param Request $request
     * @return V
     */
    abstract protected function validate(V $validator, Request $request): V;
}