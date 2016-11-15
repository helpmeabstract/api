<?php

namespace HelpMeAbstract\Entity;

use Doctrine\Common\Collections\Collection;
use HelpMeAbstract\Entity\Notification\Subject;
use Ramsey\Uuid\Uuid;

class Submission implements Subject
{
    /**
     * @var Uuid
     */
    private $identifier;

    /**
     * @var Collection|Revision[]
     */
    private $revisions;

    public function __construct(Uuid $identifier, Collection $collection)
    {
        $this->revisions = $collection;
        $this->identifier = $identifier;
    }

    /**
     * @return Collection|Revision[]
     */
    public function getRevisions() : Collection
    {
        return $this->getRevisions();
    }

    public function addRevision(Revision $revision)
    {
        $this->revisions->add($revision);
    }

    /**
     * @return User
     */
    public function getAuthor() : User
    {
        return $this->revisions->first()->getAuthor();
    }

    public function getUrl() : string
    {
        // TODO: Implement getUrl() method.
    }

    public function getExcerpt() : string
    {
        // TODO: Implement getExcerpt() method.
    }

    public function getHeadline() : string
    {
        // TODO: Implement getHeadline() method.
    }

    /**
     * @return Uuid
     */
    public function getIdentifier()
    {
        return $this->identifier;
    }
}
