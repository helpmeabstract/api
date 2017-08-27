<?php

namespace HelpMeAbstract\Permission;

use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;

trait RequiresAdminUser
{
    use RequiresCurrentUser {
        RequiresCurrentUser::requireCurrentUser as getBaseUser;
    }

    public function requireCurrentUser(ServerRequestInterface $request)
    {
        $user = $this->getBaseUser($request);

        if ($user->isAdmin()) {
            return $user;
        }

        throw new UnauthorizedException();
    }
}
