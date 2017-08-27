<?php

namespace HelpMeAbstract {

    use Psr\Http\Message\RequestInterface;
    use Psr\Http\Message\ResponseInterface;

    const CURRENT_USER_ATTRIBUTE = 'currentUser';
    const HELP_ME_ABSTRACT_COOKIE = 'hma-user-id';

    function next(RequestInterface $request, ResponseInterface $response, callable $next = null) : ResponseInterface
    {
        return $next ? $next($request, $response) : $response;
    }
}
