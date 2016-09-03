<?php


namespace HelpMeAbstract\Providers;


use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

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
            function () {
                $router = new RouteCollection();
                $router->map(
                    'GET',
                    '/',
                    function (ServerRequestInterface $request, ResponseInterface $response) {
                        $response->getBody()->write('<h1>Hello, World!</h1>');

                        return $response;
                    }
                );
                return $router;
            }
        );
    }
}
