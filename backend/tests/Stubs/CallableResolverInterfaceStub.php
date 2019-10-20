<?php


namespace App\Tests\Stubs;


use Slim\Interfaces\CallableResolverInterface;


/**
 * Class CallableResolverInterfaceStub
 * @package App\Tests\Stubs
 */
class CallableResolverInterfaceStub implements CallableResolverInterface {
    /**
     * {@inheritDoc}
     */
    public function resolve($toResolve): callable {
        return function () {
            return true;
        };
    }
}