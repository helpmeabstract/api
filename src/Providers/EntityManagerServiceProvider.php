<?php

namespace HelpMeAbstract\Providers;

use Doctrine\Common;
use Doctrine\ORM;
use HelpMeAbstract\Environment;
use League\Container\ServiceProvider\AbstractServiceProvider;

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

            $entityDirectory = __DIR__ . '/../Entities';
            $proxyDirectory = __DIR__ . '/../proxies/';

            $cache = ($environment->isTesting())
                ? new Common\Cache\ArrayCache()
                : new Common\Cache\ApcuCache();

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
    }
}
