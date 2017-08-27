<?php

declare(strict_types=1);

namespace HelpMeAbstract;

use Assert\AssertionFailedException;
use HelpMeAbstract\Middleware\CurrentUser;
use HelpMeAbstract\Middleware\Router;
use HelpMeAbstract\Repository\UserRepository;
use HelpMeAbstract\Response\BadRequestResponse;
use HelpMeAbstract\Response\NotAuthorizedResponse;
use League\Route\Http\Exception\UnauthorizedException;
use League\Route\RouteCollection;
use Psr\Http\Message\ServerRequestInterface;
use Whoops\Run;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;

final class Application
{
    public function __construct()
    {
        $this->container = new Container();
    }

    public function run()
    {
        $this->container->get(Run::class)->register();

        try {
            $currentUser = new CurrentUser($this->container->get(UserRepository::class));
            $response = $currentUser(
                $this->container->get(ServerRequestInterface::class),
                new Response(),
                (new Router(
                    $this->container->get(RouteCollection::class)
                ))
            );
        } catch (UnauthorizedException $e) {
            $response = new NotAuthorizedResponse();
        } catch (AssertionFailedException $e) {
            $response = new BadRequestResponse([$e->getMessage()]);
        }

        $this->container->get(SapiEmitter::class)->emit($response);
    }
}
