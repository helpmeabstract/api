<?php

namespace HelpMeAbstract\Provider;

use Doctrine\DBAL;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Console\Helper\HelperSet;

class DBALMigrationConfigurationServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        DBAL\Migrations\Configuration\Configuration::class,
    ];

    public function register()
    {
        $this->container->share(DBAL\Migrations\Configuration\Configuration::class, function () {

            /** @var EntityManagerHelper $entityManagerHelper */
            $entityManagerHelper = $this->container->get(HelperSet::class)->get('em');

            $actualEntityManager = $entityManagerHelper->getEntityManager();

            $connection = $actualEntityManager->getConnection();

            $configuration = new DBAL\Migrations\Configuration\Configuration($connection);

            $configuration->setName('HelpMeAbstract Migrations');
            $configuration->setMigrationsNamespace('HelpMeAbstract\DBAL\Migration');
            $configuration->setMigrationsDirectory(__DIR__ . '/../../src/DBAL/Migration');
            $configuration->setMigrationsTableName('doctrine_migration_versions');
            $configuration->registerMigrationsFromDirectory(__DIR__ . '/../DBAL/Migration');

            return $configuration;
        });
    }
}
