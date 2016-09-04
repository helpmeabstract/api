<?php

require __DIR__ . '/vendor/autoload.php';

use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;

$container = new \HelpMeAbstract\Container();
$container->addServiceProvider(new \HelpMeAbstract\Providers\EntityManagerServiceProvider());

$entityManager = $container->get(EntityManager::class);

return new HelperSet([
    'db' => new ConnectionHelper($entityManager->getConnection()),
    'em' => new EntityManagerHelper($entityManager),
]);
