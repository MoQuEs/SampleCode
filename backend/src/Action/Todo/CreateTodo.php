<?php

declare(strict_types = 1);

namespace App\Action\Todo;


use App\Action\Action;
use App\Action\EntityManagerAction;
use App\Domain\Todo;
use App\Utils\Response;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class CreateTodo
 * @package App\Action\Todo
 */
class CreateTodo extends EntityManagerAction implements Action {
    /**
     * {@inheritDoc}
     * @throws Exception
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $newTodoData = $request->getParsedBody();
        $newTodo = new Todo($newTodoData['subject'], $newTodoData['description'], $newTodoData['completed']);

        $this->em->persist($newTodo);
        $this->em->flush();

        return Response::json(200, $newTodo, $response);
    }
}
