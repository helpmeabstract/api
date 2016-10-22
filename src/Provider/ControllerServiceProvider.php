<?php

declare(strict_types=1);

namespace HelpMeAbstract\Provider;

use HelpMeAbstract\Controller;
use HelpMeAbstract\Repository\UserRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ControllerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Controller\Auth::class,
        Controller\User::class,
        Controller\Notification::class,
        Controller\Submission::class,
        Controller\Comment::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(Controller\Auth::class);
        $this->container->share(Controller\User::class, function () {
            $userRepository = $this->container->get(UserRepository::class);

            return new Controller\User($userRepository);
        });
        $this->container->share(Controller\Notification::class);
        $this->container->share(Controller\Submission::class);

        $this->container->share(Controller\Comment::class);
    }
}
