<?php


namespace HelpMeAbstract\Permission;


use const HelpMeAbstract\CURRENT_USER_ATTRIBUTE;
use HelpMeAbstract\Entity\User;
use HelpMeAbstract\NotAuthorizedException;
use League\Route\Http\Exception\UnauthorizedException;
use Psr\Http\Message\ServerRequestInterface;

trait RequiresAdminUser
{
    use RequiresCurrentUser{
        RequiresCurrentUser::requireCurrentUser as getBaseUser;
    };

    public function requireCurrentUser(ServerRequestInterface $request)
    {
        $user = $this->getBaseUser($request);

        if ( $user->isAdmin()){
            return $user;
        }

        throw new UnauthorizedException();
    }
}