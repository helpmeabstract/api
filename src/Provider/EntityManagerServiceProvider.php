<?php

namespace HelpMeAbstract\Provider;

use Doctrine\Common;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\DBAL\Types\Type;
use Doctrine\ORM;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use HelpMeAbstract\DBAL\Type\UTCDateTimeType;
use HelpMeAbstract\Environment;
use League\Container\ServiceProvider\AbstractServiceProvider;
use Symfony\Component\Console\Helper\HelperSet;

class EntityManagerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        ORM\EntityManager::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(ORM\EntityManager::class, function () {
            $environment = $this->container->get(Environment::class);

            $entityDirectory = __DIR__ . '/../Entity';
            $proxyDirectory = __DIR__ . '/../proxies/';

            Type::addType('uuid', 'Ramsey\Uuid\Doctrine\UuidType');

            Type::overrideType('datetime', UTCDateTimeType::class);
            Type::overrideType('datetimetz', UTCDateTimeType::class);

            $cache = new Common\Cache\ArrayCache();

            $config = new ORM\Configuration();
            $annotationDriver = $config->newDefaultAnnotationDriver($entityDirectory, false);
            $config->setMetadataDriverImpl($annotationDriver);
            $config->setQueryCacheImpl($cache);
            $config->setMetadataCacheImpl($cache);
            $config->setProxyDir($proxyDirectory);
            $config->setProxyNamespace('HelpMeAbstract\Proxies');

            if ($environment->isProduction()) {
                $config->setAutoGenerateProxyClasses(Common\Proxy\AbstractProxyFactory::AUTOGENERATE_NEVER);
            } else {
                $config->setAutoGenerateProxyClasses(Common\Proxy\AbstractProxyFactory::AUTOGENERATE_ALWAYS);
            }

            $dbParams = [
                'driver' => 'mysqli',
                'user' => getenv('MYSQL_USER'),
                'password' => getenv('MYSQL_PASSWORD'),
                'host' => 'db',
                'dbname' => 'helpmeabstract',             ];

            return  ORM\EntityManager::create($dbParams, $config);
        });

        $this->container->share(HelperSet::class, function () {
            $entityManager = $this->container->get(ORM\EntityManager::class);

            return new HelperSet([
                'db' => new ConnectionHelper($entityManager->getConnection()),
                'em' => new EntityManagerHelper($entityManager),
            ]);
        });
    }
}
