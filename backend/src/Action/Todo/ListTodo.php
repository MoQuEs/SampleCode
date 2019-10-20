<?php

declare(strict_types = 1);

namespace App\Action\Todo;


use App\Action\Action;
use App\Action\EntityManagerAction;
use App\Domain\Todo;
use App\Utils\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class ListTodo
 * @package App\Action\Todo
 */
class ListTodo extends EntityManagerAction implements Action {
    /**
     * {@inheritDoc}
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        /** @var Todo[] $todos */
        $todos = $this->em->getRepository(Todo::class)->findAll();
        return Response::jsonMessage(200, $todos, $response);
    }
}
