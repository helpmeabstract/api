<?php
declare(strict_types = 1);

namespace HelpMeAbstract\Providers;

use HelpMeAbstract\Controllers\User;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ControllerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        User::class
    ];
    
    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->share(User::class);
    }
}
