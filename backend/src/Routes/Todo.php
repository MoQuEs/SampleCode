<?php

declare(strict_types = 1);

namespace App\Routes;


use App\Action\Todo\ChangeStatus;
use App\Action\Todo\CreateTodo;
use App\Action\Todo\DeleteTodo;
use App\Action\Todo\EditTodo;
use App\Action\Todo\ListTodo;
use App\Validators\Todo as VTodo;
use Doctrine\ORM\EntityManager;
use Slim\App;
use UMA\DIC\Container;


/**
 * Class Todo
 * @package App\Routes
 */
class Todo extends Route {
    /**
     * {@inheritDoc}
     */
    public function setContainers(Container $c): void {
        $c->set(ListTodo::class, static function (Container $c): ListTodo {
            return new ListTodo($c->get(EntityManager::class));
        });
        $c->set(CreateTodo::class, static function (Container $c): CreateTodo {
            return new CreateTodo($c->get(EntityManager::class));
        });
        $c->set(EditTodo::class, static function (Container $c): EditTodo {
            return new EditTodo($c->get(EntityManager::class));
        });
        $c->set(DeleteTodo::class, static function (Container $c): DeleteTodo {
            return new DeleteTodo($c->get(EntityManager::class));
        });
    }

    /**
     * {@inheritDoc}
     */
    public function __invoke(App $app): void {
        $app->get('/todo', ListTodo::class);
        $app->put('/todo', CreateTodo::class)
            ->add(new VTodo\NewTodo($this->c));
        $app->post('/todo', EditTodo::class)
            ->add(new VTodo\Id($this->c))
            ->add(new VTodo\NewTodo($this->c));
        $app->delete('/todo/{id}', DeleteTodo::class)
            ->add(new VTodo\Id($this->c));
    }
}