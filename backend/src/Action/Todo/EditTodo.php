<?php

declare(strict_types = 1);

namespace App\Action\Todo;


use App\Action\Action;
use App\Action\EntityManagerAction;
use App\Domain\Todo;
use App\Utils\Response;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;


/**
 * Class EditTodo
 * @package App\Action\Todo
 */
class EditTodo extends EntityManagerAction implements Action {
    /**
     * {@inheritDoc}
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        $editTodoData = $request->getParsedBody();

        /** @var Todo $editTodo */
        $editTodo = $this->em
            ->getRepository(Todo::class)
            ->find($editTodoData['id']);

        if ($editTodo === null) {
            return Response::message(400, 'Can\'t find todo', $response);
        }

        $editTodo->setSubject($editTodoData['subject']);
        $editTodo->setDescription($editTodoData['description']);
        $editTodo->setCompleted($editTodoData['completed']);

        $this->em->persist($editTodo);
        $this->em->flush();

        return Response::json(200, $editTodo, $response);
    }
}
