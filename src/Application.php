<?php
declare(strict_types = 1);

namespace HelpMeAbstract;


use League\Route\RouteCollection;
use Zend\Diactoros\Response\SapiEmitter;

class Application
{
    public function __construct()
    {
        $this->container = new Container();
    }

    public function run()
    {
        /** @var RouteCollection $router */
        $router = $this->container->get(RouteCollection::class);
        $response = $router->dispatch($this->container->get('request'), $this->container->get('response'));
        $this->container->get(SapiEmitter::class)->emit($response);
    }

}
