<?php

declare(strict_types=1);

namespace HelpMeAbstract\Provider;

use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Controller;
use HelpMeAbstract\Repository\UserRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ControllerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Controller\User\GetAll::class,
        Controller\User\GetSingle::class,
        Controller\Auth::class
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(Controller\Auth::class, function(){
            return new Controller\Auth($this->container->get(EntityManager::class));
        });

        $this->container->share(Controller\User\GetAll::class, function () {
            $userRepository = $this->container->get(UserRepository::class);

            return new Controller\User\GetAll($userRepository);
        });

        $this->container->share(Controller\User\GetSingle::class, function () {
            $userRepository = $this->container->get(UserRepository::class);

            return new Controller\User\GetSingle($userRepository);
        });
    }
}
