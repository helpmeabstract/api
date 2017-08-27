<?php

namespace HelpMeAbstract\Provider;

use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Entity;
use HelpMeAbstract\Repository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class RepositoryServiceProvider extends AbstractServiceProvider
{
    private $repositoryEntityMap = [
        Repository\UserRepository::class => Entity\User::class,
        Repository\RevisionRepository::class => Entity\Revision::class,
    ];

    public function __construct()
    {
        $this->provides = array_keys($this->repositoryEntityMap);
    }

    public function register()
    {
        foreach ($this->repositoryEntityMap as $repositoryClass => $entityClass) {
            $this->container->share($repositoryClass, function () use ($entityClass) {
                $entityManager = $this->container->get(EntityManager::class);

                return $entityManager->getRepository($entityClass);
            });
        }
    }
}
