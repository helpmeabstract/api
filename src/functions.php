<?php

namespace HelpMeAbstract {

    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;

    const CURRENT_USER_ATTRIBUTE = 'currentUser';
    const HELP_ME_ABSTRACT_COOKIE = "hma-user-id";
    const REQUEST_HANDLER_CLASS = 'request-handler-class';

    function next(RequestInterface $request, ResponseInterface $response, callable $next = null) : ResponseInterface
    {
        return $next ? $next($request, $response) : $response;
    }
}
