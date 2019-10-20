<?php

declare(strict_types = 1);

namespace App\Action;


use Doctrine\ORM\EntityManager;


/**
 * Class EntityManagerAction
 * @package App\Action
 */
abstract class EntityManagerAction {
    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * EntityManagerAction constructor.
     * @param EntityManager $em
     */
    public function __construct(EntityManager $em) {
        $this->em = $em;
    }
}