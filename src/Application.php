<?php

declare(strict_types=1);

namespace HelpMeAbstract;

use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;
use Whoops\Run;
use Zend\Diactoros\Response\SapiEmitter;

final class Application
{
    public function __construct()
    {
        $this->container = new Container();
    }

    public function run()
    {
        $router = $this->container->get(RouteCollection::class);

        $this->container->get(Run::class)->register();

        try {
            $response = $router->dispatch(
                $this->container->get(ServerRequestInterface::class),
                $this->container->get(ResponseInterface::class)
            );
        } catch (NotFoundException $exception) {
            $response = $this->container->get(ResponseInterface::class)
                ->withStatus(StatusCode::NOT_FOUND);
        }

        $this->container->get(SapiEmitter::class)->emit($response);
    }
}
