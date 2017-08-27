<?php

namespace HelpMeAbstract\Middleware;

use const HelpMeAbstract\CURRENT_USER_ATTRIBUTE;
use const HelpMeAbstract\HELP_ME_ABSTRACT_COOKIE;
use function HelpMeAbstract\next;
use HelpMeAbstract\Repository\UserRepository;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class CurrentUser implements Middleware
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function __invoke(
        ServerRequestInterface $request,
        ResponseInterface $response,
        callable $next = null
    ): ResponseInterface {
        $userId = $request->getCookieParams()[HELP_ME_ABSTRACT_COOKIE] ?? null;

        if ($userId) {
            $request = $request->withAttribute(CURRENT_USER_ATTRIBUTE, $this->userRepository->find($userId));
        }

        return next($request, $response, $next);
    }
}
