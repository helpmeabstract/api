<?php

namespace HelpMeAbstract\Provider;

use HelpMeAbstract\Controller;
use HelpMeAbstract\HandlerStrategy;
use League\Container\ServiceProvider\AbstractServiceProvider;
use League\Route\RouteCollection;
use League\Route\RouteGroup;

class RouterServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        RouteCollection::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(
            RouteCollection::class,
            function () : RouteCollection {
                $router = new RouteCollection();
                $router->setStrategy(new HandlerStrategy());

                $router->get('/', $this->container->get(Controller\User\GetAll::class));

                $router->group(
                    '/users',
                    function (RouteGroup $userRouter) {
                        $userRouter->get('/', $this->container->get(Controller\User\GetAll::class));
                        $userRouter->get('/{id}', $this->container->get(Controller\User\GetSingle::class));
                    }
                );

                $router->group(
                    '/proposals',
                    function (RouteGroup $userRouter) {
                        $userRouter->post('/', $this->container->get(Controller\Proposal\CreateProposal::class));
                        $userRouter->get('/{id}', $this->container->get(Controller\Proposal\GetProposalRevision::class));
                        $userRouter->put('/{id}', $this->container->get(Controller\Proposal\UpdateProposal::class));
                        $userRouter->get('/{id}/revisions/{revision_id}', $this->container->get(Controller\Proposal\GetProposalRevision::class));
                        $userRouter->get('/{id}/revisions', $this->container->get(Controller\Proposal\GetProposalRevisionList::class));
                    }
                );

                $router->group(
                    '/revisions',
                    function (RouteGroup $userRouter) {
                        $userRouter->post('/{id}/comments', $this->container->get(Controller\Comment\CreateComment::class));
                        $userRouter->get('/{id}/comments', $this->container->get(Controller\Comment\GetCommentsForRevision::class));
                    }
                );

                $router->delete('/comments/{id}', $this->container->get(Controller\Comment\DeleteComment::class));

                $router->get('/auth', $this->container->get(Controller\Auth::class));

                return $router;
            }
        );
    }
}
