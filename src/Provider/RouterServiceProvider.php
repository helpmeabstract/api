<?php

namespace HelpMeAbstract\Provider;

use HelpMeAbstract\Controller;
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
                $router->group(
                    '/users',
                    function (RouteGroup $userRouter) {
                        $userController = $this->container->get(Controller\User::class);
                        $submissionController = $this->container->get(Controller\Submission::class);
                        $notificationController = $this->container->get(Controller\Notification::class);

                        $userRouter->get('/', [$userController, 'list']);
                        $userRouter->post('/', [$userController, 'create']);
                        $userRouter->put('/{id:number}', [$userController, 'update']);
                        $userRouter->get('/{id:number}', [$userController, 'get']);
                        $userRouter->delete('/{id:number}', [$userController, 'delete']);

                        $userRouter->post('/{id:number}/submissions', [$submissionController, 'create']);
                        $userRouter->get('/{id:number}/submissions', [$submissionController, 'listForUser']);

                        $userRouter->get('/{id:number}/notifications', [$notificationController, 'listForUser']);
                    }
                );

                $router->group(
                    '/notifications',
                    function (RouteGroup $notificationRouter) {
                        $notificationController = $this->container->get(Controller\Notification::class);
                        $notificationRouter->get('/{id:number}', [$notificationController, 'get']);
                        $notificationRouter->put('/{id:string}', [$notificationController, 'update']);
                    });

                $router->group(
                    '/submissions',
                    function (RouteGroup $submissionRoute) {
                        $submissionController = $this->container->get(Controller\Submission::class);
                        $submissionRoute->get('/{id:number}', [$submissionController, 'get']);
                        $submissionRoute->put('/{id:number}', [$submissionController, 'update']);
                        $submissionRoute->delete('/{id:number}', [$submissionController, 'delete']);

                        $commentController = $this->container->get(Controller\Comment::class);
                        $submissionRoute->post('/{id:number}/comments', [$commentController, 'create']);
                    }
                );

                $router->group(
                    '/comments',
                    function (RouteGroup $commentRouter) {
                        $commentController = $this->container->get(Controller\Comment::class);

                        $commentRouter->delete('/{id:number}', [$commentController, 'delete']);
                        $commentRouter->put('/{id:number}', [$commentController, 'update']);
                    }
                );

                $commentController = $this->container->get(Controller\Comment::class);
                $submissionController = $this->container->get(Controller\Submission::class);

                $router->get('/submissions', [$submissionController, 'list']);
                $router->get('/comments', [$commentController, 'list']);

                $authController = $this->container->get(Controller\Auth::class);
                $router->post('/login', [$authController, 'login']);
                $router->get('/logout', [$authController, 'logout']);

                return $router;
            }
        );
    }
}
