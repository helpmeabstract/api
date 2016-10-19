<?php

namespace HelpMeAbstract\Entity;

use HelpMeAbstract\Entity\Behavior\HasCreatedDate;
use HelpMeAbstract\Entity\Behavior\HasId;

class Comment
{
    use HasId;
    use HasCreatedDate;

    private $body;

    private $revision;

    private $user;

    private $hasBeenEdited = false;

    /**
     * @param User     $user
     * @param Revision $revision
     * @param string   $body
     */
    public function __construct(User $user, Revision $revision, string $body)
    {
        $this->user = $user;
        $this->revision = $revision;
        $this->body = $body;
    }

    /**
     * @return mixed
     */
    public function getBody() : string
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getRevision() : Revision
    {
        return $this->revision;
    }

    /**
     * @return mixed
     */
    public function getUser() : User
    {
        return $this->user;
    }

    /**
     * @param mixed $body
     */
    public function setBody($body)
    {
        $this->body = $body;
        $this->hasBeenEdited = true;
    }
}
