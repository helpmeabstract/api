<?php

declare(strict_types=1);

namespace HelpMeAbstract;

use HelpMeAbstract\Providers\ControllerServiceProvider;
use HelpMeAbstract\Providers\EntityManagerServiceProvider;
use HelpMeAbstract\Providers\LoggerServiceProvider;
use HelpMeAbstract\Providers\RouterServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Whoops\Handler;
use Whoops\Run;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class Container.
 */
final class Container extends \League\Container\Container
{
    public function __construct()
    {
        parent::__construct();

        $this->share(ResponseInterface::class, new Response());
        $this->share(SapiEmitter::class, SapiEmitter::class);
        $this->share(
            ServerRequestInterface::class,
            function () {
                return ServerRequestFactory::fromGlobals();
            }
        );

        $this->share(Environment::class, function() : Environment{
            return new Environment(getenv('env') ?: Environment::DEVELOPMENT);
        });

        $this->addServiceProvider(new LoggerServiceProvider());
        $this->addServiceProvider(new RouterServiceProvider());
        $this->addServiceProvider(new EntityManagerServiceProvider());
        $this->addServiceProvider(new ControllerServiceProvider());

        $this->inflector(LoggerAwareInterface::class)->invokeMethod('setLogger', [LoggerInterface::class]);

        $this->share(Run::class, function () {
            $whoops = new Run();
            $whoops->pushHandler(new Handler\PrettyPageHandler());
            $jsonHandler = new Handler\JsonResponseHandler();
            $jsonHandler->addTraceToOutput(true);
            $whoops->pushHandler($jsonHandler);

            return $whoops;
        });
    }
}
