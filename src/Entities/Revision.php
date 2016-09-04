<?php

namespace HelpMeAbstract\Entities;

use Doctrine\Common\Collections\ArrayCollection;
use HelpMeAbstract\Entities\Behavior\HasCreatedDate;
use HelpMeAbstract\Entities\Behavior\HasId;

class Revision
{
    use HasId;
    use HasCreatedDate;

    /**
     * @var int
     */
    private $abstractId;

    /**
     * @var User
     */
    private $user;

    /**
     * @var ArrayCollection
     */
    private $comments;

    public function __construct(User $user, int $abstractId = null)
    {
        $this->comments = new ArrayCollection();

        $this->user = $user;
        $this->abstractId = $abstractId ?: rand();
    }

    /**
     * @return int
     */
    public function getAbstractId() : int
    {
        return $this->abstractId;
    }

    /**
     * @return User
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @return ArrayCollection
     */
    public function getComments() : ArrayCollection
    {
        return $this->comments;
    }
}