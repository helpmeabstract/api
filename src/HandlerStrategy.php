<?php


namespace HelpMeAbstract;


use League\Route\Route;
use League\Route\Strategy\RequestResponseStrategy;

class HandlerStrategy extends RequestResponseStrategy
{
    /**
     * {@inheritdoc}
     */
    public function dispatch(callable $controller, array $vars, Route $route = null)
    {
        $this->setRequest(
            $this->getRequest()->withAttribute(REQUEST_HANDLER_CLASS, get_class($controller))
        );

        return parent::dispatch($controller, $vars, $route);
    }
}