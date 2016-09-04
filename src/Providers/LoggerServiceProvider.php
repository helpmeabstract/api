<?php

declare(strict_types=1);

namespace HelpMeAbstract\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor;
use Psr\Log\LoggerInterface;

class LoggerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [LoggerInterface::class];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(
            LoggerInterface::class,
            function () : LoggerInterface {
                $handler = new StreamHandler('php://stdout');
                $handler->setFormatter(new JsonFormatter());
                $handler->pushProcessor(new Processor\WebProcessor());
                $handler->pushProcessor(new Processor\MemoryUsageProcessor());
                $handler->pushProcessor(new Processor\MemoryPeakUsageProcessor());
                $handler->pushProcessor(new Processor\IntrospectionProcessor());

                return new Logger('hma', [$handler]);
            }
        );
    }
}
