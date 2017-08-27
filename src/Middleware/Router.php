<?php


namespace HelpMeAbstract\Middleware;


use League\Route\Http\Exception\NotFoundException;
use League\Route\RouteCollection;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Teapot\StatusCode;

class Router implements Middleware
{
    /**
     * @var RouteCollection
     */
    private $router;

    public function __construct(RouteCollection $router)
    {
        $this->router = $router;
    }

    public function __invoke(ServerRequestInterface $request, ResponseInterface $response, callable $next = null): ResponseInterface
    {
        try {
            $response = $this->router->dispatch($request, $response);
        } catch (NotFoundException $exception) {
            $response = $response->withStatus(StatusCode::NOT_FOUND);
        }

        return ($next) ? $next($request, $response) : $response;
    }
}