<?php
declare(strict_types = 1);

namespace HelpMeAbstract;

use HelpMeAbstract\Providers\RouterServiceProvider;
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

        $this->addServiceProvider(new RouterServiceProvider());
    }
}
