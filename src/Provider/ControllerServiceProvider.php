<?php

declare(strict_types=1);

namespace HelpMeAbstract\Provider;

use Doctrine\ORM\EntityManager;
use HelpMeAbstract\Controller;
use HelpMeAbstract\Repository\CommentRepository;
use HelpMeAbstract\Repository\RevisionRepository;
use HelpMeAbstract\Repository\UserRepository;
use League\Container\ServiceProvider\AbstractServiceProvider;

class ControllerServiceProvider extends AbstractServiceProvider
{
    protected $provides = [
        Controller\User\GetAll::class,
        Controller\User\GetSingle::class,
        Controller\Auth::class,
        Controller\Proposal\GetProposalRevisionList::class,
        Controller\Proposal\GetProposalRevision::class,
        Controller\Proposal\CreateProposal::class,
        Controller\Comment\CreateComment::class,
        Controller\Comment\GetCommentsForRevision::class,
        Controller\Comment\DeleteComment::class,
    ];

    /**
     * Use the register method to register items with the container via the
     * protected $this->container property or the `getContainer` method
     * from the ContainerAwareTrait.
     */
    public function register()
    {
        $this->container->share(Controller\Auth::class, function () {
            return new Controller\Auth(
                $this->container->get(EntityManager::class),
                $this->container->get(UserRepository::class)
                );
        });

        $this->container->share(Controller\User\GetAll::class, function () {
            $userRepository = $this->container->get(UserRepository::class);

            return new Controller\User\GetAll($userRepository);
        });

        $this->container->share(Controller\User\GetSingle::class, function () {
            $userRepository = $this->container->get(UserRepository::class);

            return new Controller\User\GetSingle($userRepository);
        });

        $this->container->share(Controller\Proposal\GetProposalRevision::class, function () {
            $repository = $this->container->get(RevisionRepository::class);

            return new Controller\Proposal\GetProposalRevision($repository);
        });

        $this->container->share(Controller\Proposal\GetProposalRevisionList::class, function () {
            $repository = $this->container->get(RevisionRepository::class);

            return new Controller\Proposal\GetProposalRevisionList($repository);
        });

        $this->container->share(Controller\Proposal\CreateProposal::class, function () {
            return new Controller\Proposal\CreateProposal(
                $this->container->get(EntityManager::class),
                $this->container->get(RevisionRepository::class)
            );
        });

        $this->container->share(Controller\Proposal\UpdateProposal::class, function () {
            return new Controller\Proposal\UpdateProposal(
                $this->container->get(EntityManager::class),
                $this->container->get(RevisionRepository::class)
            );
        });

        $this->container->share(Controller\Comment\CreateComment::class, function () {
            return new Controller\Comment\CreateComment(
                $this->container->get(EntityManager::class),
                $this->container->get(RevisionRepository::class),
                $this->container->get(CommentRepository::class)
            );
        });

        $this->container->share(Controller\Comment\DeleteComment::class, function () {
            return new Controller\Comment\DeleteComment(
                $this->container->get(EntityManager::class),
                $this->container->get(CommentRepository::class)
            );
        });

        $this->container->share(Controller\Comment\GetCommentsForRevision::class, function () {
            return new Controller\Comment\GetCommentsForRevision(
                $this->container->get(CommentRepository::class)
            );
        });
    }
}
