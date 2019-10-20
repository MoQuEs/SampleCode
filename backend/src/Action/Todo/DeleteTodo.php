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
 * Class DeleteTodo
 * @package App\Action\Todo
 */
class DeleteTodo extends EntityManagerAction implements Action {
    /**
     * {@inheritDoc}
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, array $args): ResponseInterface {
        /** @var Todo $deleteTodo */
        $deleteTodo = $this->em
            ->getRepository(Todo::class)
            ->find($args['id']);

        if ($deleteTodo === null) {
            return Response::message(400, 'Can\'t find todo', $response);
        }

        $this->em->remove($deleteTodo);
        $this->em->flush();

        return Response::code(204, $response);
    }
}
