<?php

namespace HelpMeAbstract\Entities;

use Assert\Assertion;
use HelpMeAbstract\Entities\Behavior\HasCreatedDate;
use HelpMeAbstract\Entities\Behavior\HasId;

class Notification
{
    const TYPE_COMMENT_RECEIVED = "comment_received";
    const TYPE_SUBMISSION_SUBMITTED = "submission_recieved";

    use HasId;
    use HasCreatedDate;

    /**
     * @var bool
     */
    private $hasBeenRead = false;

    /**
     * @var
     */
    private $dateRead;

    /**
     * @var bool
     */
    private $hasBeenSent = false;

    /**
     * @var
     */
    private $dateSent;

    /**
     * @var string
     */
    private $type;

    /**
     * @var User
     */
    private $user;

    /**
     * @var Resource
     */
    private $resource;

    /**
     * @param User $user
     * @param Resource $resource
     * @param string $type
     */
    public function __construct(User $user, Resource $resource, string $type)
    {
        Assertion::inArray($type, [self::TYPE_COMMENT_RECEIVED, self::TYPE_SUBMISSION_SUBMITTED]);

        $this->user = $user;
        $this->resource = $resource;
        $this->type = $type;
    }

    public function markRead()
    {
        $this->hasBeenRead = true;
        $this->dateRead = new \DateTime();
    }

    public function markUnread()
    {
        $this->hasBeenRead = false;
        $this->dateRead = null;
    }

    public function markSent()
    {
        $this->hasBeenSent = true;
        $this->dateSent = new \DateTime();
    }
}