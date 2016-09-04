<?php

namespace HelpMeAbstract\Providers;

use HelpMeAbstract\Controllers\User;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use League\Route\RouteGroup;

class RouterServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        RouteCollection::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(
            RouteCollection::class,
            function () : RouteCollection {
                $router = new RouteCollection();
                $router->group(
                    '/users',
                    function (RouteGroup $userRouter) {
                        $userRouter->get('/', [$this->container->get(User::class), 'list']);
                        $userRouter->post('/', [$this->container->get(User::class), 'create']);
                        $userRouter->put('/{id:number}', [$this->container->get(User::class), 'update']);
                        $userRouter->get('/{id:number}', [$this->container->get(User::class), 'get']);
                        $userRouter->delete('/{id:number}', [$this->container->get(User::class), 'delete']);
                    }
                );

                return $router;
            }
        );
    }
}
