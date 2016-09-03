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
     *
     * @return void
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
                        $userRouter->map('GET', '/', [$this->container->get(User::class), 'list']);
                    }
                );

                return $router;
            }
        );
    }
}
