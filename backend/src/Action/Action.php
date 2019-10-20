<?php

declare(strict_types = 1);

namespace App\Action;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class Action
 * @package App\Action
 */
interface Action {
    /**
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     * @param array $args
     * @return ResponseInterface
     */
    function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface;
}