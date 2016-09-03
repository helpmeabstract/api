<?php
declare(strict_types = 1);

namespace HelpMeAbstract;

use HelpMeAbstract\Providers\ControllerServiceProvider;
use HelpMeAbstract\Providers\LoggerServiceProvider;
use HelpMeAbstract\Providers\RouterServiceProvider;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;
use Zend\Diactoros\Response;
use Zend\Diactoros\Response\SapiEmitter;
use Zend\Diactoros\ServerRequestFactory;

/**
 * Class Container
 *
 * @package HelpMeAbstract
 */
class Container extends \League\Container\Container
{
    public function __construct()
    {
        parent::__construct();

        $this->share('response', Response::class);
        $this->share(SapiEmitter::class, SapiEmitter::class);
        $this->share(
            'request',
            function () {
                return ServerRequestFactory::fromGlobals($_SERVER, $_GET, $_POST, $_COOKIE, $_FILES);
            }
        );

        $this->addServiceProvider(new LoggerServiceProvider());
        $this->addServiceProvider(new RouterServiceProvider());
        $this->addServiceProvider(new ControllerServiceProvider());

        $this->inflector(LoggerAwareInterface::class)->invokeMethod('setLogger', [LoggerInterface::class]);
    }
}
