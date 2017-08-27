<?php

namespace HelpMeAbstract\Provider;

use HelpMeAbstract\Controller;
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

                $router->get('/', $this->container->get(Controller\User\GetAll::class));

                $router->group(
                    '/users',
                    function (RouteGroup $userRouter) {
                        $userRouter->get('/', $this->container->get(Controller\User\GetAll::class));
                        $userRouter->get('/{id}', $this->container->get(Controller\User\GetSingle::class));
                    }
                );

                $router->get('/auth', $this->container->get(Controller\Auth::class));

                return $router;
            }
        );
    }
}
