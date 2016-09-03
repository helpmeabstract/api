<?php
declare(strict_types = 1);

namespace HelpMeAbstract\Providers;

use League\Container\ServiceProvider\AbstractServiceProvider;
use Monolog\Formatter\JsonFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\IntrospectionProcessor;
use Monolog\Processor\MemoryPeakUsageProcessor;
use Monolog\Processor\MemoryUsageProcessor;
use Monolog\Processor\WebProcessor;
use Psr\Log\LoggerInterface;

class LoggerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [LoggerInterface::class];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     *
     * @return void
     */
    public function register()
    {
        $this->container->share(
            LoggerInterface::class,
            function () : LoggerInterface {
                $handler = new StreamHandler('php://stdout');
                $handler->setFormatter(new JsonFormatter());
                $handler->pushProcessor(new WebProcessor());
                $handler->pushProcessor(new MemoryUsageProcessor());
                $handler->pushProcessor(new MemoryPeakUsageProcessor());
                $handler->pushProcessor(new IntrospectionProcessor());

                return new Logger("hma", [$handler]);
            }
        );
    }
}
