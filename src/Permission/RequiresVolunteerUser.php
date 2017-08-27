<?php

namespace HelpMeAbstract\Permission;

use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;

trait RequiresVolunteerUser
{
    use RequiresCurrentUser {
        RequiresCurrentUser::requireCurrentUser as getBaseUser;
    }

    public function requireCurrentUser(ServerRequestInterface $request)
    {
        $user = $this->getBaseUser($request);

        if ($user->isVolunteer() || $user->isAdmin()) {
            return $user;
        }

        throw new UnauthorizedException();
    }
}
