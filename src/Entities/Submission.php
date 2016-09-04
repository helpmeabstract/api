<?php

namespace HelpMeAbstract\Entities;

use Doctrine\Common\Collections\Collection;

class Submission
{
    /**
     * @var Collection|Revision[]
     */
    private $revisions;

    public function __construct(Collection $collection)
    {
        $this->revisions = $collection;
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
     * @param string $name
     * @return mixed
     */
    public function __call($name)
    {
        return $this->revisions->$name;
    }
}