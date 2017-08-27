<?php

declare(strict_types=1);

namespace HelpMeAbstract;

use HelpMeAbstract\Output\FractalAwareInterface;
use League\Fractal\Manager;
use League\Fractal\Serializer\JsonApiSerializer;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Whoops\Handler;
use Whoops\Run;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

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

        $this->share(Environment::class, function () : Environment {
            return new Environment(getenv('env') ?: Environment::DEVELOPMENT);
        });

        $this->share(Manager::class, function(){
            return (new Manager())->setSerializer(new JsonApiSerializer());
        });

        $this->addServiceProvider(new Provider\LoggerServiceProvider());
        $this->addServiceProvider(new Provider\RouterServiceProvider());
        $this->addServiceProvider(new Provider\EntityManagerServiceProvider());
        $this->addServiceProvider(new Provider\DBALMigrationConfigurationServiceProvider());
        $this->addServiceProvider(new Provider\RepositoryServiceProvider());
        $this->addServiceProvider(new Provider\ControllerServiceProvider());

        $this->inflector(LoggerAwareInterface::class)->invokeMethod('setLogger', [LoggerInterface::class]);
        $this->inflector(FractalAwareInterface::class)->invokeMethod('setManager', [Manager::class]);

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
