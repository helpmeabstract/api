<?php

namespace HelpMeAbstract\Permission;

use const HelpMeAbstract\CURRENT_USER_ATTRIBUTE;
use HelpMeAbstract\Entity\User;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;

trait RequiresCurrentUser
{
    public function requireCurrentUser(ServerRequestInterface $request): User
    {
        $currentUser = $request->getAttribute(CURRENT_USER_ATTRIBUTE);

        if ($currentUser === null || !$currentUser instanceof User) {
            throw new UnauthorizedException();
        }

        return $currentUser;
    }
}
